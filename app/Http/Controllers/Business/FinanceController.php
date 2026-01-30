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

class FinanceController extends Controller
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
        // dd($request->all());
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
            // Cela évite de lancer le processus si une donnée critique manque
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
            // dd($data);
            // 4. Appel du Service
            // Le service gère l'appel API (CinetPay, Wave, etc.) et l'enregistrement DB
            $result = $this->VoteService->processVote($data);
// dd($result);
            // 5. Gestion de la réponse du Service
            // Rappel du format retourné par processVote :
            // ['status', 'message', 'transactions_id', 'api_processing', 'api_response']

            $httpCode = 200;
            $success = true;

            // On analyse le statut retourné par ton service
            switch ($result['status']) {
                case 'approved':
                case 'successful':
                case 'success':
                    // Paiement réussi instantanément (ex: Carte, ou Wave direct)
                    $icon = 'success';
                    break;

                case 'pending':
                case 'pending_validation':
                    // En attente de validation sur le mobile (Push USSD)
                    $icon = 'info';
                    break;

                case 'failed':
                case 'declined':
                case 'error':
                    $success = false;
                    $httpCode = 400; // Bad Request
                    $icon = 'error';
                    break;

                default:
                    $success = false;
                    $httpCode = 500;
                    $icon = 'warning';
                    break;
            }

            // 6. Retour JSON standardisé pour le Frontend
            return response()->json([
                'success' => $success,
                'status'  => $result['status'], // approved, pending, failed
                'icon'    => $icon,             // Pour SweetAlert
                'message' => $result['message'],
                'transaction_id' => $result['transactions_id'],
                // Tu peux ajouter des données de redirection si c'est une carte bancaire
                'redirect_url' => $result['api_response']['data']['payment_url'] ?? null
            ], $httpCode);
        } catch (\Exception $e) {
            Log::error("Erreur Controller Payment: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'status'  => 'error',
                'icon'    => 'error',
                'message' => __('messages.server_error')
            ], 500);
        }
    }
}
