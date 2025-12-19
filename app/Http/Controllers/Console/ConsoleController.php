<?php

namespace App\Http\Controllers\Console;


use App\Http\Controllers\Controller;
use App\Models\Campagne;
use App\Services\SendMail;
use App\Services\Upload;
use App\Services\CustomerService;
use App\Services\CampagneService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;

class ConsoleController  extends Controller
{
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

            #Transfert et upload du fichier logo
            $name_file = ($request->hasFile('logo'))
                ? Upload::uploadFile($request->logo)
                : "default_logo.png";

            // Formatage des données
            $dateCustomer = [
                'customer_id' => Str::uuid(),
                'name_customer' => $request->name,
                'phonenumber_customer' => $request->phonenumber,
                'email_customer' => $request->email_customer,
                'role' => 'customer',
                'password' => Hash::make('defaultpassword123'),
                'entreprise' => $request->entreprise,
                'user_id' => $request->user_id,
                'email_entreprise' => $request->email,
                'phonenumber_entreprise' => $request->phonenumber,
                'pays_siege' => $request->pays_siege,
                'adresse' => $request->adresse,
                'logo' => $name_file,
                'site_web' => $request->link_website,
                'link_facebook' => $request->link_facebook,
                'link_instagram' => $request->link_instagram,
                'link_linkedin' => $request->link_linkedin,
                'link_twitter' => $request->link_twitter,
                'link_youtube' => $request->link_youtube,
                'link_tiktok' => $request->link_tiktok,
                'is_active' => false,
            ];

            // Sauvegarde des données via le service
            CustomerService::createNewCustomer($dateCustomer);

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

    #CAMPAGNES
    public function listCampagne()
    {
        $title_back = "Tableau de bord";
        $link_back = "list_campagne";
        $title = "Liste campagnes";
        return view('console.listCampagnes', compact('title', 'title_back', 'link_back'));
    }

    #SAVE CAMPAGNE
    public function saveCampagne(Request $request)
    {
        // dd($request->all());
        try {
            #Transfert et upload du fichier logo
            $image_couverture = ($request->hasFile('image_couverture'))
                ? Upload::uploadFile($request->image_couverture)
                : "";

            $condition_participation = ($request->hasFile('condition_participation'))
                ? Upload::uploadFile($request->condition_participation)
                : "";

            // Formatage des données
            $dateCampagne = [
                'campagne_id' => Str::uuid(),
                'customer_id' => $request->customer_id,
                'name' => $request->name,
                'description' => $request->description,
                'image_couverture' => $image_couverture,
                'text_cover_isActive' => $request->text_cover_isActive,
                'inscription_isActive' => $request->inscription_isActive,
                'inscription_date_debut' => $request->inscription_date_debut,
                'inscription_date_fin' => $request->inscription_date_fin,
                'heure_debut_inscription' => $request->heure_debut_inscription,
                'heure_fin_inscription' => $request->heure_fin_inscription,
                'identifiants_personnalises_isActive' => $request->identifiants_personnalises_isActive,
                'afficher_montant_pourcentage' => $request->afficher_montant_pourcentage,
                'ordonner_candidats_votes_decroissants' => $request->ordonner_candidats_votes_decroissants,
                'quantite_vote' => $request->adresse,
                'color_primaire' => $request->color_primaire,
                'color_secondaire' => $request->color_secondaire,
                'condition_participation' => $condition_participation,
                'is_active' => true,
            ];
            dd($dateCampagne, $request->all());
            // Sauvegarde des données via le service
            CustomerService::createNewCampagne($dateCampagne);

            return redirect()->route('list_campagne')->with('success', 'Campagne créée avec succès !');
        } catch (\Exception $th) {
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
