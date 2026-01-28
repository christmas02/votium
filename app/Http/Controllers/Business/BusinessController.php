<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;
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


class BusinessController extends Controller
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

    #DASHBOARD
    public function index()
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "back_office_business";
            $title = "Espace Business";
            return view('business.index', compact('title', 'title_back', 'link_back'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #PARAMÈTRE COMPTE
    public function profile()
    {
        try {
            $title_back = "Tableau de bord";
            $link_back = "back_office_business";
            $title = "Paramètre du compte";
            $user = auth()->user();
            $customer = $this->CustomerService->customerByIdUser($user->user_id);

            $paymentMethods = PaymentMethod::cases();

            //Liste des comptes de retrait
            $compteRetraits = $this->CustomerService->listWithdrawalAccountByCustomer($customer->customer_id);

            return view('business.profile', compact('title', 'title_back', 'link_back', 'user', 'customer', 'paymentMethods', 'compteRetraits'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('messages.server_error'));
        }
    }

    #UPDATE PROFILE
    public function updateProfile(UserRequest $request)
    {
        try {

            // Mise à jour du mot de passe si fourni
            if ($request->filled('password')) {
                $password = $this->setting->hashPassword($request->password);
            } else {
                $password = $request->old_password;
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
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du profil.'
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'Profil mis à jour avec succès !'
            ], 200);
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour du profil : " . $th->getMessage(), [
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #UPDATE CUSTOMER
    public function updateCustomer(CustomerRequest $request)
    {
        try {
            // dd($request->all());
            // Initialisation du logo : on garde l'ancien par défaut
            $name_file = $request->old_logo ?? "default_logo.png";

            // Transfert et upload du fichier logo si présent
            if ($request->hasFile('logo')) {
                // Supprimer l'ancien fichier si ce n'est pas le logo par défaut
                if ($request->old_logo && $request->old_logo !== "default_logo.png") {
                    Files::deleteFile($request->old_logo);
                }

                // Upload du nouveau logo
                $name_file = Files::uploadFile($request->logo);
            }

            // Formatage des données
            $dateCustomer = [
                'customer_id' => $request->customer_id,
                'entreprise' => $request->entreprise,
                'user_id' => $request->user_id,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
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
            $saved = $this->CustomerService->UpdateProfileCustomer($dateCustomer);
            //Vérification simple
            if (!$saved) {
                // Suppression du fichier uploadé en cas d'erreur
                if (isset($name_file) && $name_file !== "default_logo.png") {
                    Files::deleteFile($name_file);
                };

                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour de l entreprise.'
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'Client et entreprise créés avec succès !'
            ], 200);
        } catch (\Exception $th) {

            // Journaliser l'erreur
            Log::error("Erreur lors de la mise à jour de l entreprise : " . $th->getMessage(), [
                'request_data' => $request->except('password', 'logo'),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }



    #COMPTES RETRAIT
    public function listCompteRetrait()
    {
        $title_back = "Tableau de bord";
        $link_back = "list_compte_retrait";
        $title = "Liste comptes retrait";
        return view('business.listCompteRetraits', compact('title', 'title_back', 'link_back'));
    }

    #SAVE COMPTE RETRAIT
    public function saveCompteRetrait(WithdrawalAccountRequest $request)
    {
        try {

            #Formatage des données
            $dateCompteRetrait = [
                'withdrawal_account_id' => $this->setting->generateUuid(),
                'customer_id' => $request->customer_id,
                'payment_methode' => $request->payment_methode,
                'account_name' => $request->account_name,
                'phone_number' => $request->phone_number,
                'is_active' => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CustomerService->createWithdrawalAccount($dateCompteRetrait);

            //Vérification simple
            if ($saved) {

                return response()->json([
                    'success' => true,
                    'message' => 'Compte retrait créé avec succès !'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création du compte retrait.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la création du compte retrait : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #UPDATE COMPTE RETRAIT
    public function updateCompteRetrait(WithdrawalAccountRequest $request)
    {
        try {

            #Formatage des données
            $dateCompteRetrait = [
                'withdrawal_account_id' => $request->withdrawal_account_id,
                'customer_id' => $request->customer_id,
                'payment_methode' => $request->payment_methode,
                'account_name' => $request->account_name,
                'phone_number' => $request->phone_number,
                'is_active' => true,
            ];

            // Sauvegarde des données via le service
            $saved = $this->CustomerService->updateWithdrawalAccount($dateCompteRetrait);

            //Vérification simple
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Compte retrait mis à jour avec succès !'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du compte retrait.'
                ], 500);
            }
        } catch (\Exception $th) {
            Log::error("Erreur lors de la mise à jour du compte retrait : " . $th->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $th->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    #DELETE COMPTE RETRAIT
    public function deleteCompteRetrait(Request $request)
    {
        try {

            // Trouver le compte retrait
            $deleted = $this->CustomerService->deleteWithdrawalAccount($request->account_id);
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Compte retrait non trouvé.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Compte retrait supprimé avec succès !'
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression du compte retrait : " . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    
}
