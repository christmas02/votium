<?php

namespace App\Http\Controllers\Console;


use App\Http\Controllers\Controller;
use App\Models\Campagne;
use App\Services\SendMail;
use App\Services\Setting;
use App\Services\Files;
use App\Services\CustomerService;
use App\Services\CampagneService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use PhpParser\Node\Stmt\TryCatch;

class ConsoleController  extends Controller
{
    protected CustomerService $CustomerService;
    protected CampagneService $CampagneService;
    protected Setting $setting;
    protected Files $files;

    public function __construct(
        CustomerService $CustomerService,
        CampagneService $CampagneService,
        Setting $setting,
        Files $files
    ) {
        $this->CustomerService = $CustomerService;
        $this->CampagneService = $CampagneService;
        $this->setting = $setting;
        $this->files = $files;
    }


    public function index()
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "back_office_console";
            $title = "Console d'administration";
            return view('console.index', compact('title', 'title_back', 'link_back'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de l'affichage de la console : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #PROFILE
    public function profile()
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "profile";
            $title = "Profil Administrateur";
            $user = auth()->user();
            return view('console.profile', compact('title', 'title_back', 'link_back', 'user'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de l'affichage du profil : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        try {
            
            
            // Mise à jour du mot de passe si fourni
            if ($request->filled('password')) {
                $password = $this->setting->hashPassword($request->password);
            }
            $data = [
                'user_id' => $request->user_id,
                'name' => $request->name,
                'phonenumber' => $request->phonenumber,
                'email' => $request->email,
                'password' => $password,
            ];

            $saved = $this->CustomerService->UpdateAccountCustomer($data);

            if (!$saved) {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du profil.');
            }
            return redirect()->route('console.profile')->with('success', 'Profil mis à jour avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour du profil : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #CUSTOMERS
    public function listCustomer()
    {
        try {
            $customers = $this->CustomerService->listCustmer()->sortByDesc('created_at');
            // dd( $customers);
            $title_back = "Tableau de bord";
            $link_back = "list_customer";
            $title = "Liste Clients";
            return view('console.listCustomer', compact('title', 'title_back', 'link_back', 'customers'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de la récupération des clients : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #SAVE CUSTOMER
    public function saveCustomer(Request $request)
    {
        try {
            #Transfert et upload du fichier logo
            $name_file = ($request->hasFile('logo'))
                ? Files::uploadFile($request->logo)
                : "default_logo.png";

            // Formatage des données
            $dateCustomer = [
                'customer_id' => $this->setting->generateUuid(),
                'name' => $request->name,
                'phonenumber' => $request->phonenumber,
                'email' => $request->email_customer,
                'role' => 'customer',
                'password' => $this->setting->hashPassword("12345678Aa"),
                'entreprise' => $request->entreprise,
                'user_id' => $this->setting->generateUuid(),
                'email_customer' => $request->email,
                'phonenumber_customer' => $request->phonenumber_entreprise,
                'pays_siege' => $request->pays_siege,
                'adresse' => $request->adresse,
                'logo' => $name_file,
                'link_website' => $request->link_website,
                'link_facebook' => $request->link_facebook,
                'link_instagram' => $request->link_instagram,
                'link_linkedin' => $request->link_linkedin,
                'link_youtube' => $request->link_youtube,
                'link_tiktok' => $request->link_tiktok,
                'is_active' => false,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CustomerService->createNewCustomer($dateCustomer);
            //Vérification simple
            if (!$saved) {
                // Suppression du fichier uploadé en cas d'erreur
                if (isset($name_file) && $name_file !== "default_logo.png") {
                    Files::deleteFile($name_file);
                };
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du client et de l entreprise.');
            }

            return redirect()->route('console.list_customer')->with('success', 'Client et entreprise créés avec succès !');
        } catch (\Exception $th) {
            // Suppression du fichier uploadé en cas d'erreur
            if (isset($name_file) && $name_file !== "default_logo.png") {
                Files::deleteFile($name_file);
            };
            // Journaliser l'erreur
            Log::error("Erreur lors de la création du customer : " . $th->getMessage(), [
                'request_data' => $request->except('password', 'logo'),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #DELETE CUSTOMER
    public function deleteCustomer(Request $request)
    {
        try {
            dd($request->all());
            $customerId = $request->input('customer_id');

            // Trouver le customer
            $customer = Customer::where('customer_id', $customerId)->first();

            if (!$customer) {
                return redirect()->back()->with('error', 'Client non trouvé.');
            }

            // Mettre is_active à false
            $customer->update(['is_active' => false]);

            return redirect()->route('console.list_customer')->with('success', 'Client supprimé avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la suppression du customer : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #DETAIL CUSTOMER
    public function detailCustomer($idcustomer)
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "detail_customer";
            $title = "Détail Client";

            $customer = $this->CustomerService->Customer($idcustomer);

            if (!$customer) {
                return redirect()->back()->with('error', "Le client n'existe pas.");
            }
            $user = User::where('user_id', $customer->user_id)->first();

            return view('console.detailCustomer', compact('title', 'title_back', 'link_back', 'customer', 'user'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de l'affichage de la detail page du customer : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #VERIFICATION CUSTOMER
    // public function verificationCustomer()
    // {
    //     $title_back = "Tableau de bord";
    //     $link_back = "verification_customer";
    //     $title = "Verification customer";
    //     return view('mails.inscriptioncustomer', compact('title', 'title_back', 'link_back'));
    // }

    #EDIT PASSWORD CUSTOMER
    public function editpasswordCustomer($email)
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "editpassword_customer";
            $title = "Edition mot de passe Client";

            return view('console.editpasswordCustomer', compact('title', 'title_back', 'link_back', 'email'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de l'affichage de la page de modification du mot de passe du customer : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #UPDATE PASSWORD CUSTOMER
    public function updatePasswordCustomer(Request $request)
    {
        try {
            // dd($request->all());
            $password = $this->setting->hashPassword($request->password);

            // Mise à jour du mot de passe
            $updated = $this->CustomerService->saveNewPassword($request->email, $password);

            if (!$updated) {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour du mot de passe.');
            }

            return redirect()->route('business.espace')->with('success', 'Mot de passe mis à jour avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour du mot de passe du customer : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #CAMPAGNES
    public function listCampagne()
    {
        try {
            $campagnes = $this->CampagneService->listCampagnes()->sortByDesc('created_at');
           
            $customers = $this->CustomerService->listCustmer()
                ->pluck('entreprise', 'customer_id')
                ->toArray();
            $title_back = "Tableau de bord";
            $link_back = "list_campagne";
            $title = "Liste Campagnes";
            return view('console.listCampagnes', compact('title', 'title_back', 'link_back', 'campagnes', 'customers'));
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
    public function saveCampagne(Request $request)
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
                return redirect()
                    ->route('console.list_campagne')
                    ->with('success', 'Campagne créée avec succès !');
            } else {
                // Supprimer les fichiers si échec
                foreach ($uploadedFiles as $filePath) {
                    Files::deleteFile($filePath);
                }
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Erreur lors de la création de la campagne.');
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
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #UPDATE CAMPAGNE
    public function updateCampagne(Request $request)
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
                return redirect()
                    ->route('console.list_campagne')
                    ->with('success', 'Campagne mise à jour avec succès !');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Erreur lors de la mise à jour de la campagne.');
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour de la campagne : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #DELETE CAMPAGNE
    public function deleteCampagne(Request $request)
    {
        try {
            dd($request->all());
            $campagne_id = $request->input('campagne_id');

            // Trouver le campagne
            $campagne = Campagne::where('campagne_id', $campagne_id)->first();

            if (!$campagne) {
                return redirect()->back()->with('error', 'Campagne non trouvée.');
            }

            // Mettre is_active à false
            $campagne->update(['is_active' => false]);
            return redirect()->route('console.list_campagne')->with('success', 'Campagne supprimée avec succès !');
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

    #DETAIL CAMPAGNE
    public function detailCampagne($idCampagne)
    {
        try {
            $campagne = $this->CampagneService->detailCampagne($idCampagne);
            $customer = $this->CustomerService->Customer($campagne->customer_id);
            if (!$campagne) {
                return redirect()->back()->with('error', 'Campagne non trouvée.');
            }
            $title_back = "Tableau de bord";
            $link_back = "detail_campagne";
            $title = $campagne->name;
            return view('console.detailCampagne', compact('title', 'title_back', 'link_back', 'campagne', 'customer'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de l'affichage de la detail page de la campagne : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }
}
