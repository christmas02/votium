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
        return view('console.index');
    }

    #CUSTOMERS
    public function listCustomer()
    {
        $title_back = "Tableau de bord";
        $link_back = "list_customer";
        $title = "Liste Customer";
        return view('console.listCustomer', compact('title', 'title_back', 'link_back'));
    }

    #SAVE CUSTOMER
    public function saveCustomer(Request $request)
    {
        try {
            // dd($request->all());
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
                'password' => $this->setting->hashPassword("password123"),
                'entreprise' => $request->entreprise,
                'user_id' => $request->user_id,
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
            // dd($dateCustomer);
            // Sauvegarde des données via le service
            $this->CustomerService->createNewCustomer($dateCustomer);

            return redirect()->route('list_customer')->with('success', 'Client et entreprise créés avec succès !');
        } catch (\Exception $th) {
            // Journaliser l'erreur
            Log::error("Erreur lors de la création du customer : " . $th->getMessage(), [
                'request_data' => $request->except('password', 'logo'),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la création du customer : ' . $th->getMessage());
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

            return redirect()->route('list_customer')->with('success', 'Client supprimé avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la suppression du customer : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la suppression du client : ' . $th->getMessage());
        }
    }

    #DETAIL CUSTOMER
    public function detailCustomer()
    {
        $title_back = "Tableau de bord";
        $link_back = "detail_customer";
        $title = "Profile customer";
        return view('console.detailCustomer', compact('title', 'title_back', 'link_back'));
    }

    #VERIFICATION CUSTOMER
    public function verificationCustomer()
    {
        $title_back = "Tableau de bord";
        $link_back = "verification_customer";
        $title = "Verification customer";
        return view('mails.inscriptioncustomer', compact('title', 'title_back', 'link_back'));
    }

    #CAMPAGNES
    public function listCampagne()
    {
        try {
            $campagnes = $this->CampagneService->listCampagnes();
            $title_back = "Tableau de bord";
            $link_back = "list_campagne";
            $title = "Liste Campagnes";
            return view('console.listCampagnes', compact('title', 'title_back', 'link_back', 'campagnes'));
        } catch (\Exception $th) {
            Log::error("Erreur lors de la récupération des campagnes : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la récupération des campagnes : ' . $th->getMessage());
        }
    }

    #SAVE CAMPAGNE
    public function saveCampagne(Request $request)
    {
        #Pour garder trace des fichiers uploadés
        $uploadedFiles = [];
        try {
            #Transfert et upload du fichier logo
            $uploadedFiles['image_couverture'] = ($request->hasFile('image_couverture'))
                ? Files::uploadFile($request->image_couverture)
                : "default_logo.png";

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
                'text_cover_isActive' => $request->text_cover_isActive,
                'inscription_isActive' => $request->inscription_isActive,
                'inscription_date_debut' => $request->inscription_date_debut,
                'inscription_date_fin' => $request->inscription_date_fin,
                'heure_debut_inscription' => $request->heure_debut_inscription,
                'heure_fin_inscription' => $request->heure_fin_inscription,
                'identifiants_personnalises_isActive' => $request->identifiants_personnalises_isActive,
                'afficher_montant_pourcentage' => $request->afficher_montant_pourcentage,
                'ordonner_candidats_votes_decroissants' => $request->ordonner_candidats_votes_decroissants,
                'quantite_vote' => $request->quantite_vote,
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
                    ->route('list_customer')
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
            return redirect()->back()->with('error', 'Erreur lors de la création de la campagne : ' . $th->getMessage());
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
            return redirect()->route('list_campagne')->with('success', 'Campagne supprimée avec succès !');
        } catch (\Exception $th) {
            Log::error("Erreur lors de la suppression du campagne : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la campagne : ' . $th->getMessage());
        }
    }

    #VUE CAMPAGNE
    public function vueCampagne()
    {
        $title_back = "Tableau de bord";
        $link_back = "vue_campagne";
        $title = "Vue campagne";
        return view('business.vueCampagne', compact('title', 'title_back', 'link_back'));
    }
}
