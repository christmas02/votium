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

class CandidatController extends Controller
{
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

    #CANDIDATS
    public function listCandidat()
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "list_candidat";
            $title = "Liste des Candidats";

            $user = auth()->user();
            $customer = $this->CustomerService->customerByIdUser($user->user_id);

            $campagnes = $this->CampagneService->listCampagnesByCustomerId($customer->customer_id);

            // Récupération de toutes les étapes pour les campagnes du client
            $etapes = collect();
            foreach ($campagnes as $item) {
                // $item est un tableau avec la clé 'campagne' qui contient le modèle Campagne
                $campagne = $item['campagne'] ?? null;
                if (!$campagne) {
                    continue;
                }

                $etapesForCampagne = $this->CampagneService->listEtapesByCampagneId($campagne->campagne_id);
                $etapes = $etapes->merge($etapesForCampagne);
            }

            // Récupération de toutes les catégories pour les campagnes du client
            $categories = collect();
            foreach ($campagnes as $item) {
                $campagne = $item['campagne'] ?? null;
                if (!$campagne) {
                    continue;
                }

                $categoriesForCampagne = $this->CampagneService->listCategoriesByCampagneId($campagne->campagne_id);
                $categories = $categories->merge($categoriesForCampagne);
            }

            return view('business.listCandidats', compact('title', 'title_back', 'link_back', 'campagnes', 'etapes', 'categories'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de la récupération des candidats : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #RECHERCHE CANDIDAT
    public function rechercheCandidat(Request $request)
    {
        try {
            $filters = [
                'campagne_id' => $request->campagne_id,
                'etape_id'    => $request->etape_id,
                'category_id' => $request->category_id,
            ];

            $candidats = $this->CandidatureService->searchCandidat($filters);

            //Transformer en Collection
            $collection = collect($candidats);

            //Appliquer la recherche (si le champ search est rempli)
            if ($request->filled('search')) {
                $searchTerm = strtolower($request->search);
                $collection = $collection->filter(function ($candidat) use ($searchTerm) {
                    return str_contains(strtolower($candidat->name ?? ''), $searchTerm) ||
                        str_contains(strtolower($candidat->email ?? ''), $searchTerm);
                });
            }

            //Gérer la pagination manuelle
            $perPage = 12;
            $page = (int) $request->get('page', 1);
            $total = $collection->count();

            // On découpe la collection pour n'avoir que les 12 éléments de la page demandée
            $pagedData = $collection->slice(($page - 1) * $perPage, $perPage)->values();

            return response()->json([
                'data'         => $pagedData,
                'current_page' => $page,
                'last_page'    => ceil($total / $perPage),
                'total'        => $total
            ]);
        } catch (\Exception $th) {
            Log::error("Erreur lors de la recherche des candidats : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Erreur lors de la recherche des candidats'], 500);
        }
    }

    #SAVE CANDIDAT
    public function saveCandidat(CandidatRequest $request)
    {
        try {

            #Traitement de la photo
            $name_file = ($request->hasFile('photo'))
                ? Files::uploadFile($request->photo)
                : "default_logo.png";

            #Formatage des données
            $dateCandidat = [
                'candidat_id' => $this->setting->generateUuid(),
                'campagne_id' => $request->campagne_id,
                'etape_id' => $request->etape_id,
                'category_id' => $request->category_id,
                'candidat_etap_id' => $this->setting->generateUuid(),
                'name' => $request->name,
                'sexe' => $request->sexe,
                'date_naissance' => $request->date_naissance,
                'profession' => $request->profession,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'photo' => $name_file,
                'ville' => $request->ville,
                'pays' => $request->pays,
                'description' => $request->description,
                'data' => $request->data ?? null,
                'is_active' => true,
            ];

            $saved = $this->CandidatureService->newCandidat($dateCandidat);

            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Candidat créé avec succès !'
                ], 200);
            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création du candidat.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la création du candidat : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #UPDATE CANDIDAT
    public function updateCandidat(CandidatRequest $request)
    {
        try {
            #Traitement de la photo
            if ($request->hasFile('photo')) {
                #Supprimer l'ancien fichier si différent du défaut
                if ($request->old_photo && $request->old_photo !== "logo.png") {
                    Files::deleteFile($request->old_photo);
                }
                $name_file = Files::uploadFile($request->photo);
            } else {
                $name_file = $request->old_photo;
            }

            #Formatage des données
            $dateCandidat = [
                'candidat_id' => $request->candidat_id,
                'name' => $request->name,
                'sexe' => $request->sexe,
                'date_naissance' => $request->date_naissance,
                'profession' => $request->profession,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'photo' => $name_file,
                'ville' => $request->ville,
                'pays' => $request->pays,
                'description' => $request->description,
                'data' => $request->data ?? null,
                'is_active' => true,
            ];

            $updated = $this->CandidatureService->updateInfoCandidat($dateCandidat);


            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Candidat mis à jour avec succès !'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Aucune modification effectuée ou candidat introuvable.'
            ], 500);
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour du candidat : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #DETAIL CANDIDAT
    public function detailCandidat($idCandidat)
    {
        try {

            $candidat = $this->CandidatureService->candidat($idCandidat);
            if (!$candidat) {
                return redirect()->back()->with('error', 'Candidat non trouvé.');
            }
            $title_back = "Tableau de bord";
            $link_back = "detail_candidat";
            $title = $candidat->name;
            return view('business.detailCandidat', compact('title', 'title_back', 'link_back', 'candidat'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de l'affichage de la detail page du candidat : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }
    #DELETE CANDIDAT
    public function deleteCandidat(Request $request)
    {
        try {
            $candidat_id = $request->input('candidat_id');

            // Trouver le candidat
            $candidat = $this->CandidatureService->deleteCandidat($candidat_id);
            if (!$candidat) {
                return response()->json([
                    'success' => false,
                    'message' => 'candidat introuvable.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Candidat supprimé avec succès !'
            ], 200);
        } catch (\Exception $th) {
            Log::error("Erreur lors de la suppression du candidat : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }
}
