<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Campagne;
use App\Services\SendMail;
use App\Services\Setting;
use App\Services\Files;
use App\Services\CustomerService;
use App\Services\CampagneService;
use App\Enums\PaymentMethod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Etape;
use Carbon\Carbon;
use App\Services\CandidatureService;
use PhpParser\Node\Stmt\TryCatch;

use App\Http\Requests\CampagneRequest;
use App\Http\Requests\CandidatRequest;
use App\Http\Requests\CategoryCampagneRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\EtapeRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\WithdrawalAccountRequest;

class CampagneController extends Controller
{
    //
    protected CustomerService $CustomerService;
    protected CampagneService $CampagneService;
    protected CandidatureService $CandidatureService;
    protected Setting $setting;
    protected Files $files;

    public function __construct(
        CustomerService $CustomerService,
        CampagneService $CampagneService,
        CandidatureService $CandidatureService,
        Setting $setting,
        Files $files
    ) {
        $this->CustomerService = $CustomerService;
        $this->CampagneService = $CampagneService;
        $this->CandidatureService = $CandidatureService;
        $this->setting = $setting;
        $this->files = $files;
    }

    #CAMPAGNES
    public function listCampagne()
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "list_campagne";
            $title = "Liste des Campagnes";

            $user = auth()->user();
            $customer = $this->CustomerService->customerByIdUser($user->user_id);
            $campagnes = $this->CampagneService->listCampagnesByCustomerId($customer->customer_id);

            // dd($campagnes);

            return view('business.listCampagnes', compact('title', 'title_back', 'link_back', 'campagnes', 'customer'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de la récupération des campagnes : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #SAVE CAMPAGNE
    public function saveCampagne(CampagneRequest $request)
    {
        #Pour garder trace des fichiers uploadés
        $uploadedFiles = [];
        try {
            #Transfert et upload du fichier
            $uploadedFiles['image_couverture'] = ($request->hasFile('image_couverture'))
                ? Files::uploadFile($request->image_couverture)
                : "default_image_couverture.jpg";

            $uploadedFiles['condition_participation'] = ($request->hasFile('condition_participation'))
                ? Files::uploadFile($request->condition_participation)
                : "default_condition.pdf";

            #Formatage des données
            $dateCampagne = [
                'campagne_id' => $this->setting->generateUuid(),
                'customer_id' => $request->customer_id,
                'name' => $request->name,
                'description' => $request->description,
                'image_couverture' => $uploadedFiles['image_couverture'],
                'text_cover_isActive' => $request->text_cover_isActive ? 1 : 0,
                'inscription_isActive' => $request->inscription_isActive ? 1 : 0,
                'inscription_date_debut' => $request->inscription_date_debut,
                'inscription_date_fin' => $request->inscription_date_fin,
                'heure_debut_inscription' => $request->heure_debut_inscription,
                'heure_fin_inscription' => $request->heure_fin_inscription,
                'identifiants_personnalises_isActive' => $request->identifiants_personnalises_isActive ? 1 : 0,
                'afficher_montant_pourcentage' => $request->afficher_montant_pourcentage,
                'ordonner_candidats_votes_decroissants' => $request->ordonner_candidats_votes_decroissants ? 1 : 0,
                'quantite_vote' => $request->input('quantite_vote'),
                'color_primaire' => $request->color_primaire,
                'color_secondaire' => $request->color_secondaire,
                'condition_participation' => $uploadedFiles['condition_participation'],
                'is_active' => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CampagneService->saveNewCampagne($dateCampagne);

            //Vérification simple
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Campagne créée avec succès !'
                ], 200);
            } else {
                // Supprimer les fichiers si échec
                foreach ($uploadedFiles as $filePath) {
                    Files::deleteFile($filePath);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de la campagne.'
                ], 500);
            }
        } catch (\Exception $th) {
            //Suppression des fichiers uploadés
            foreach ($uploadedFiles as $filePath) {
                Files::deleteFile($filePath);
            }
            Log::error("Erreur lors de la création de la campagne : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }


    #UPDATE CAMPAGNE
    public function updateCampagne(CampagneRequest $request)
    {
        #Pour garder trace des fichiers uploadés
        $uploadedFiles = [];
        try {
            #Transfert et upload du fichier
            if ($request->hasFile('image_couverture')) {
                #Supprimer l'ancien fichier si différent du défaut
                if ($request->old_image_couverture && $request->old_image_couverture !== "default_image_couverture.jpg") {
                    Files::deleteFile($request->old_image_couverture);
                }
                $uploadedFiles['image_couverture'] = Files::uploadFile($request->image_couverture);
            } else {
                $uploadedFiles['image_couverture'] = $request->old_image_couverture;
            }

            if ($request->hasFile('condition_participation')) {
                #Supprimer l'ancien fichier si différent du défaut
                if ($request->old_condition_participation && $request->old_condition_participation !== "default_condition.pdf") {
                    Files::deleteFile($request->old_condition_participation);
                }
                $uploadedFiles['condition_participation'] = Files::uploadFile($request->condition_participation);
            } else {
                $uploadedFiles['condition_participation'] = $request->old_condition_participation;
            }

            #Formatage des données
            $dateCampagne = [
                'campagne_id' => $request->campagne_id,
                'customer_id' => $request->customer_id,
                'name' => $request->name,
                'description' => $request->description,
                'image_couverture' => $uploadedFiles['image_couverture'],
                'text_cover_isActive' => $request->text_cover_isActive ? 1 : 0,
                'inscription_isActive' => $request->inscription_isActive ? 1 : 0,
                'inscription_date_debut' => $request->inscription_date_debut,
                'inscription_date_fin' => $request->inscription_date_fin,
                'heure_debut_inscription' => $request->heure_debut_inscription,
                'heure_fin_inscription' => $request->heure_fin_inscription,
                'identifiants_personnalises_isActive' => $request->identifiants_personnalises_isActive ? 1 : 0,
                'afficher_montant_pourcentage' => $request->afficher_montant_pourcentage,
                'ordonner_candidats_votes_decroissants' => $request->ordonner_candidats_votes_decroissants ? 1 : 0,
                'quantite_vote' => $request->input('quantite_vote'),
                'color_primaire' => $request->color_primaire,
                'color_secondaire' => $request->color_secondaire,
                'condition_participation' => $uploadedFiles['condition_participation'],
                'is_active' => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CampagneService->updateExistingCampagne($dateCampagne);

            //Vérification simple
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Campagne mise à jour avec succès !'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour de la campagne.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour de la campagne : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #DELETE CAMPAGNE
    public function deleteCampagne(Request $request)
    {
        try {

            $campagne_id = $request->input('campagne_id');

            // Trouver le campagne
            $campagne = Campagne::where('campagne_id', $campagne_id)->first();

            if (!$campagne) {
                return redirect()->back()->with('error', 'Campagne non trouvée.');
            }

            // Mettre is_active à false
            $campagne->update(['is_active' => false]);
            return redirect()->back()->with('success', 'Campagne supprimée avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la suppression du campagne : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #SITE CAMPAGNE
    public function siteCampagne($idCampagne)
    {
        $campagne = $this->CampagneService->detailCampagne($idCampagne);
        $customer = $this->CustomerService->Customer($campagne->customer_id);

        $paymentMethods = PaymentMethod::cases();

        //Liste des comptes de retrait
        $compteRetraits = $this->CustomerService->listWithdrawalAccountByCustomer($customer->customer_id);

        $etapes = $this->CampagneService->listEtapesByCampagneId($idCampagne);
        $categories = $this->CampagneService->listCategoriesByCampagneId($idCampagne);

        $assignments = DB::table('candidat_etap_category_campagnes as cecc')
            ->join('candidats as c', 'cecc.candidat_id', '=', 'c.candidat_id')
            ->leftJoin('votes as v', function ($join) use ($idCampagne) {
                $join->on('v.candidat_id', '=', 'c.candidat_id')
                    ->where('v.campagne_id', '=', $idCampagne);
            })
            ->where('cecc.campagne_id', $idCampagne)
            ->select(
                'c.*',
                'cecc.etape_id',
                'cecc.category_id',
                DB::raw('COUNT(v.vote_id) as votes_count'),
                DB::raw('COALESCE(SUM(v.quantity), 0) as total_quantity')
            )
            ->groupBy(
                'c.candidat_id',
                'cecc.etape_id',
                'cecc.category_id'
            )
            ->get();
        //Calculer le total global de la campagne
        $totalCampagne = $assignments->sum('total_quantity');

        //Ajouter le pourcentage dans PHP
        $assignments = $assignments->map(function ($candidat) use ($totalCampagne) {
            $candidat->vote_percentage = $totalCampagne > 0
                ? round(($candidat->total_quantity / $totalCampagne) * 100, 2)
                : 0;
            return $candidat;
        });


        $now = Carbon::now(); // Date et heure actuelle du système

        foreach ($etapes as $etape) {
            // 1. Créer des objets Carbon pour le début et la fin
            $debut = Carbon::parse($etape->date_debut . ' ' . $etape->heure_debut);
            $fin = Carbon::parse($etape->date_fin . ' ' . $etape->heure_fin);

            // 2. Variable pour savoir si l'étape est en cours (ouverte)
            $etape->is_active_now = $now->between($debut, $fin);

            // 3. Variable pour savoir si l'étape est future (pas encore commencée)
            $etape->is_upcoming = $now->lt($debut);

            // 4. Calcul du compte à rebours si l'étape n'a pas encore commencé
            if ($etape->is_upcoming) {
                $diff = $now->diff($debut);
                $etape->countdown = [
                    'days'    => $diff->d,
                    'hours'   => $diff->h,
                    'minutes' => $diff->i,
                    'label'   => "Ouverture dans {$diff->d}j {$diff->h}h {$diff->i}min"
                ];
            } else {
                $etape->countdown = null;
            }

            // Filtrage des candidats par étape
            $etape->candidats = $assignments->where('etape_id', $etape->etape_id)->values();
        }

        foreach ($categories as $category) {
            $category->candidats = $assignments->where('category_id', $category->category_id)->values();
        }

        $campagne->etapes = $etapes;
        $campagne->categories = $categories;

        // Dans votre contrôleur, avant le return view :
        $selectedEtapeId = request('etape_id', $campagne->etapes->first()->etape_id ?? null);
        $selectedCategoryId = request('category_id');
        $selectedEtape = $campagne->etapes->firstWhere('etape_id', $selectedEtapeId);

        $title_back = "Tableau de bord";
        $link_back = "detail_campagne";
        $title = $campagne->name;

        // dd($campagne);
        return view('siteCampagne.index', compact(
            'title',
            'title_back',
            'link_back',
            'campagne',
            'customer',
            'selectedEtape',
            'selectedEtapeId',
            'selectedCategoryId',
            'paymentMethods',
            'compteRetraits'
        ));
    }


    #CATEGORIES CAMPAGNES
    public function listCategorie($campagne_id)
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "list_categorie";
            $title = "Liste des Catégories";

            $categories = $this->CampagneService->listCategoriesByCampagneId($campagne_id);

            return view('business.listCategoriesCampagne', compact('title', 'title_back', 'link_back', 'categories', 'campagne_id'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de la récupération des catégories campagne : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #SAVE CATEGORIE
    public function saveCategorie(CategoryCampagneRequest $request)
    {
        try {

            #Formatage des données
            $dateCategorie = [
                'category_id' => $this->setting->generateUuid(),
                'campagne_id' => $request->campagne_id,
                'name' => $request->name,
                'description' => $request->description,
                'icon' => $request->icon,
                'is_active' => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CampagneService->saveNewCategory($dateCategorie);

            //Vérification simple
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie créée avec succès !'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de la catégorie.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la création de la catégorie : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }
    #UPDATE CATEGORIE
    public function updateCategorie(CategoryCampagneRequest $request)
    {
        try {
            #Formatage des données
            $dateCategorie = [
                'category_id' => $request->category_id,
                'campagne_id' => $request->campagne_id,
                'name' => $request->name,
                'description' => $request->description,
                'icon' => $request->icon,
                'is_active' => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CampagneService->updateCategory($dateCategorie);

            //Vérification simple
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie mise à jour avec succès !'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour de la catégorie.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour de la catégorie : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #DELETE CATEGORIE
    public function deleteCategorie(Request $request)
    {
        try {

            $category_id = $request->input('category_id');

            // Trouver le categorie
            $categorie = $this->CampagneService->detailCategory($category_id);
            if (!$categorie) {
                return redirect()->back()->with('error', 'Catégorie non trouvée.');
            }

            return redirect()->back()->with('success', 'Catégorie supprimée avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la suppression de la catégorie : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #ETAPES CAMPAGNES
    public function listEtape($customer_id, $campagne_id)
    {
        try {

            $title_back = "Tableau de bord";
            $link_back = "list_etape";
            $title = "Liste des Étapes";

            $campagnes = $this->CampagneService->listCampagnesByCustomerId($customer_id);

            return view('business.listEtapesCampagne', compact('title', 'title_back', 'link_back', 'campagnes', 'customer_id', 'campagne_id'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de la récupération des étapes : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #RECHERCHE ETAPE CAMPAGNE
    public function rechercheEtapeCampagne($campagne_id)
    {
        try {

            $etapes = $this->CampagneService->listEtapesByCampagneId($campagne_id);
            return response()->json($etapes);
        } catch (\Exception $th) {
            Log::error("Erreur lors de la recherche des étapes : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Erreur lors de la recherche des étapes'], 500);
        }
    }

    #SAVE ETAPE
    public function saveEtape(EtapeRequest $request)
    {
        try {

            $packages = collect($request->packages ?? [])
                ->filter(fn($p) => isset($p['votes'], $p['montant']) && is_numeric($p['votes']) && is_numeric($p['montant']))
                ->map(fn($p) => [
                    'vote'    => (int) $p['votes'],
                    'montant' => (int) $p['montant'],
                ])
                ->values()
                ->toArray();

            $packagesJson = json_encode($packages);

            #Formatage des données
            $dateEtape = [
                'etape_id'     => $this->setting->generateUuid(),
                'campagne_id'  => $request->campagne_id,
                'name'         => $request->name,
                'date_debut'   => $request->date_debut,
                'heure_debut'  => $request->heure_debut,
                'date_fin'     => $request->date_fin,
                'heure_fin'    => $request->heure_fin,
                'description' => $request->description,
                'type_eligibility' => $request->type_eligibility ?? null,
                'seuil_selection' => $request->seuil_selection ?? null,
                'reinitialisation' => $request->reinitialisation ? 1 : 0,
                'prix_vote'    => $request->prix_vote,
                'package'     => $packagesJson,
                'is_active'    => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CampagneService->saveNewEtape($dateEtape);

            //Vérification simple
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Étape créée avec succès !'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de l\'étape en base de données.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la création de l étape : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #UPDATE ETAPE
    public function updateEtape(EtapeRequest $request)
    {
        try {

            $packages = collect($request->packages ?? [])
                ->filter(fn($p) => isset($p['votes'], $p['montant']) && is_numeric($p['votes']) && is_numeric($p['montant']))
                ->map(fn($p) => [
                    'vote'    => (int) $p['votes'],
                    'montant' => (int) $p['montant'],
                ])
                ->values()
                ->toArray();

            $packagesJson = json_encode($packages);

            // Préparation des données pour l'update
            $dataUpdate = [
                'etape_id'     => $request->etape_id,
                'campagne_id'  => $request->campagne_id,
                'name'             => $request->name,
                'date_debut'       => $request->date_debut,
                'heure_debut'      => $request->heure_debut,
                'date_fin'         => $request->date_fin,
                'heure_fin'        => $request->heure_fin,
                'description'      => $request->description,
                'prix_vote'        => $request->prix_vote,
                'package'          => $packagesJson,
                'type_eligibility' => $request->type_eligibility ?? null,
                'seuil_selection' => $request->seuil_selection ?? null,
                'reinitialisation' => $request->reinitialisation ? 1 : 0,
            ];

            $updated = $this->CampagneService->updateEtape($dataUpdate);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Étape mise à jour avec succès !'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Aucune modification effectuée ou étape introuvable.'
            ], 500);
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour de l étape : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #DELETE ETAPE
    public function deleteEtape($etape_id)
    {
        try {

            // Suppression via votre service ou Eloquent
            $deleted = $this->CampagneService->deleteEtape($etape_id);

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'L\'étape a été supprimée avec succès.'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cette étape.'
            ], 500);
        } catch (\Exception $e) {
            Log::error("Erreur Delete Etape : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }
}
