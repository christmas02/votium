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
use App\Services\VoteService;
use App\Enums\PaymentMethod;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\Etape;
use App\Models\Vote;
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

class RetraitController extends Controller
{
    protected CustomerService $CustomerService;
    protected CampagneService $CampagneService;
    protected CandidatureService $CandidatureService;
    protected VoteService $VoteService;
    protected Setting $setting;
    protected Files $files;

    public function __construct(
        CustomerService $CustomerService,
        CampagneService $CampagneService,
        CandidatureService $CandidatureService,
        VoteService $VoteService,
        Setting $setting,
        Files $files
    ) {
        $this->CustomerService = $CustomerService;
        $this->CampagneService = $CampagneService;
        $this->CandidatureService = $CandidatureService;
        $this->VoteService = $VoteService;
        $this->setting = $setting;
        $this->files = $files;
    }

    #VOTES
    public function listVote()
    {
        $title_back = "Tableau de bord";
        $link_back = "list_vote";
        $title = "Liste votes";
        return view('business.listVotes', compact('title', 'title_back', 'link_back'));
    }

    #RETRAITS
    public function listRetrait()
    {
        $title_back = "Tableau de bord";
        $link_back = "list_retrait";
        $title = "Liste retraits";
        return view('business.listRetraits', compact('title', 'title_back', 'link_back'));
    }

    #TRANSACTIONS PAYMENTS VOTES
    public function initiatePaymentVote(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'candidat_id' => 'required',
            'campagne_id' => 'required',
            'etate_id'    => 'required',
            'quantity'    => 'required|integer|min:1',
            'amount'      => 'required|numeric',
            'name'        => 'required|string',
            'email'       => 'nullable|email',
            'phoneNumber' => 'required|string',
            'provider'    => 'required|string',
            'otpCode'     => 'nullable|string',
        ]);

        try {
            // 2. Vérification Spécifique (OTP Orange) avant d'appeler le service

            if (in_array($validated['provider'], ['orange', 'orange_money'])) {
                if (empty($request->input('otpCode')) || $request->input('otpCode') === '0000') {
                    return response()->json([
                        'success' => false,
                        'status' => 'validation_error',
                        'message' => 'Le code OTP est obligatoire pour Orange Money.'
                    ], 422);
                }
            }

            // 3. Construction des données pour le service
            $data = [
                'vote_id' => $this->setting->generateUuid(),
                'candidat_id'    => $validated['candidat_id'],
                'campagne_id'    => $validated['campagne_id'],
                'etate_id'       => $validated['etate_id'],
                'quantity'       => $validated['quantity'],
                'amount'         => $validated['amount'],
                'currency'       => 'XOF',
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phoneNumber'    => $validated['phoneNumber'],
                'provider'       => $validated['provider'],
                'otpCode'       => $request->input('otpCode'),
                'description'    => "Achat de {$validated['quantity']} votes",
            ];

            //4. Appel du Service: Le service gère l'appel API (CinetPay, Wave, etc.) et l'enregistrement DB
            $result = $this->VoteService->processVote($data);

            // 5. Gestion de la réponse du Service Rappel du format retourné par processVote : ['status', 'message', 'transactions_id', 'api_processing', 'api_response']

            $httpCode = 200;
            $success = true;

            // On analyse le statut retourné par le service
            switch ($result['status']) {
                case 'approved':
                case 'successful':
                case 'success':
                    $icon = 'success';
                    break;

                case 'pending':
                case 'pending_validation':
                    $icon = 'info';
                    break;

                case 'failed':
                case 'declined':
                case 'error':
                    $success = false;
                    $httpCode = 400;
                    $icon = 'error';
                    break;

                default:
                    $success = false;
                    $httpCode = 500;
                    $icon = 'warning';
                    break;
            }

            // 6. Retour JSON
            return response()->json([
                'success' => $success,
                'status'  => $result['status'], // pending, failed
                'icon'    => $icon,            
                'message' => $result['message'],
                'transaction_id' => $result['transactions_id'],
                'redirect_url' => $result['api_response']['data']['payment_url'] ?? null
            ], $httpCode);
        } catch (\Exception $e) {
            Log::error("Erreur Controller initiatePaymentVote: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'status'  => 'error',
                'icon'    => 'error',
                'message' => __('messages.server_error')
            ], 500);
        }
    }

    public function TestInitiatePaymentVote(Request $request)
    {

        try {
           
            $result = [
                'status' => 'pending',
                'message' => 'Simulation Locale : Initiation validée',
                'transactions_id' => '415c767b-4210-49ef-9158-25b505a3e6ac', // Ton ID existant
                'api_response' => ['data' => ['payment_url' => null]]
            ];

            return response()->json([
                'success' => true, // On force true pour que le JS lance le polling
                'status'  => $result['status'],
                'icon'    => 'info',
                'message' => $result['message'],
                'transaction_id' => $result['transactions_id'],
                'redirect_url' => null
            ], 200);
        } catch (\Exception $e) {
            // ...
        }
    }

    #VERIFIER LE STATUS DE LA TRANSACTION(Polling)
    public function verifyPaymentVote($transactionId)
    {
        try {
            // 1. Appel Réel (pour avoir la structure de données correcte)
            $result = $this->VoteService->checkStatusTransaction($transactionId);

            // 2. Gestion des erreurs internes du service
            if (isset($result['status']) && $result['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message']
                ], 500);
            }

            // 3. Récupération de l'URL de redirection
            $campagneUrl = url('/');

            if (isset($result['vote_id'])) {
                $vote = Vote::find($result['vote_id']);
                if ($vote) {
                    $campagneUrl = "/business/site_campagne/" . $vote->campagne_id;
                }
            }

            // 4. Construction de la réponse
            $response = [
                'status' => $result['status'],
                'receipt_url' => $result['linkInvoice'] ?? null,
                'campagne_url' => $campagneUrl
            ];
            // dd($response);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error("Erreur CheckStatus: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
