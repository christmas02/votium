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

class VoteController extends Controller
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

        return view('business.listVotes', compact('title', 'title_back', 'link_back', 'campagnes', 'etapes', 'categories'));
    }

    #Méthode pour l'AJAX de recherche et filtrage des votes
    public function rechercheVote(Request $request)
    {
        try {
            // 1. Récupération et préparation des filtres
            $filters = [
                'campagne_id' => $request->input('campagne_id'),
                'etape_id'    => $request->input('etape_id'),
                'date_debut'  => $request->input('date_debut'),
                'date_fin'    => $request->input('date_fin'),
                'status'      => $request->input('status'),
            ];

            // 2. Appel de votre Service
            $data = $this->VoteService->searchVote($filters);

            // 3. Rendu de la vue partielle HTML
            // Le render() peut échouer si la vue n'existe pas ou si $data['results'] est mal formé
            $html = view('components.votes_table_rows', [
                'votes' => $data['results'] ?? collect()
            ])->render();

            // 4. Retour de la réponse JSON pour l'AJAX
            return response()->json([
                'html' => $html,
                'total_votes' => number_format($data['total_quantity'] ?? 0, 0, ',', ' '),
                'total_montant' => number_format($data['total_montant'] ?? 0, 0, ',', ' ')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erreur AJAX rechercheVote : ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            // 2. On renvoie une réponse JSON d'erreur
            return response()->json([
                'error' => true,
                'message' => 'Une erreur est survenue lors du traitement.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    #TRANSACTIONS PAYMENTS VOTES
    // public function initiatePaymentVote(Request $request)
    // {
    //     // 1. Validation
    //     $validated = $request->validate([
    //         'candidat_id' => 'required',
    //         'campagne_id' => 'required',
    //         'etate_id'    => 'required',
    //         'quantity'    => 'required|integer|min:1',
    //         'amount'      => 'required|numeric',
    //         'name'        => 'required|string',
    //         'email'       => 'nullable|email',
    //         'phoneNumber' => 'required|string',
    //         'provider'    => 'required|string',
    //         'otpCode'     => 'nullable|string',
    //     ]);

    //     try {
    //         // 2. Vérification Spécifique (OTP Orange) avant d'appeler le service
    //         if (in_array($validated['provider'], ['orange', 'orange_money'])) {
    //             if (empty($request->input('otpCode')) || $request->input('otpCode') === '0000') {
    //                 return response()->json([
    //                     'success' => false,
    //                     'status' => 'validation_error',
    //                     'message' => 'Le code OTP est obligatoire pour Orange Money.'
    //                 ], 422);
    //             }
    //         }

    //         // 3. Construction des données pour le service
    //         $data = [
    //             'vote_id' => $this->setting->generateUuid(),
    //             'candidat_id'    => $validated['candidat_id'],
    //             'campagne_id'    => $validated['campagne_id'],
    //             'etate_id'       => $validated['etate_id'],
    //             'quantity'       => $validated['quantity'],
    //             'amount'         => $validated['amount'],
    //             'currency'       => 'XOF',
    //             'name'     => $validated['name'],
    //             'email'    => $validated['email'],
    //             'phoneNumber'    => $validated['phoneNumber'],
    //             'provider'       => $validated['provider'],
    //             'otpCode'       => $request->input('otpCode'),
    //             'description'    => "Achat de {$validated['quantity']} votes",
    //         ];

    //         //4. Appel du Service: Le service gère l'appel API (CinetPay, Wave, etc.) et l'enregistrement DB
    //         $result = $this->VoteService->processVote($data);

    //         // 5. Gestion de la réponse du Service Rappel du format retourné par processVote : ['status', 'message', 'transactions_id', 'api_processing', 'api_response']
    //         $httpCode = 200;
    //         $success = true;

    //         // On analyse le statut retourné par le service
    //         switch ($result['status']) {
    //             case 'approved':
    //             case 'successful':
    //             case 'success':
    //                 $icon = 'success';
    //                 break;

    //             case 'pending':
    //             case 'pending_validation':
    //                 $icon = 'info';
    //                 break;

    //             case 'failed':
    //             case 'declined':
    //             case 'error':
    //                 $success = false;
    //                 $httpCode = 400;
    //                 $icon = 'error';
    //                 break;

    //             default:
    //                 $success = false;
    //                 $httpCode = 500;
    //                 $icon = 'warning';
    //                 break;
    //         }

    //         // 7. Extraction sécurisée de l'URL de redirection
    //         // On cherche l'URL à plusieurs endroits possibles selon l'opérateur
    //         $redirectUrl = null;
    //         if (!empty($result['api_response'])) {
    //             $redirectUrl = $result['api_response']['data']['payment_url'] // Standard CinetPay/Hub2
    //                 ?? $result['api_response']['wave_launch_url'] // Standard Wave direct
    //                 ?? $result['api_response']['url'] // Autre standard
    //                 ?? null;
    //         }

    //         // 6. Retour JSON
    //         return response()->json([
    //             'success' => $success,
    //             'status'  => $result['status'], // pending, failed
    //             'icon'    => $icon,
    //             'message' => $result['message'],
    //             'transaction_id' => $result['transactions_id'],
    //             'redirect_url' => $redirectUrl
    //         ], $httpCode);
    //     } catch (\Exception $e) {
    //         Log::error("Erreur Controller initiatePaymentVote: " . $e->getMessage());

    //         return response()->json([
    //             'success' => false,
    //             'status'  => 'error',
    //             'icon'    => 'error',
    //             'message' => __('messages.server_error')
    //         ], 500);
    //     }
    // }

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
            // 2. Vérification Spécifique (OTP Orange)
            if (in_array($validated['provider'], ['orange', 'orange_money'])) {
                if (empty($request->input('otpCode')) || $request->input('otpCode') === '0000') {
                    return response()->json([
                        'success' => false,
                        'status' => 'validation_error',
                        'message' => 'Le code OTP est obligatoire pour Orange Money.'
                    ], 422);
                }
            }

            // 3. Construction des données
            $data = [
                'vote_id'     => $this->setting->generateUuid(),
                'candidat_id' => $validated['candidat_id'],
                'campagne_id' => $validated['campagne_id'],
                'etate_id'    => $validated['etate_id'],
                'quantity'    => $validated['quantity'],
                'amount'      => $validated['amount'],
                'currency'    => 'XOF',
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'phoneNumber' => $validated['phoneNumber'],
                'provider'    => $validated['provider'],
                'otpCode'     => $request->input('otpCode'),
                'description' => "Achat de {$validated['quantity']} votes",
            ];

            // 4. Appel du Service
            $result = $this->VoteService->processVote($data);

            // 5. Gestion de la réponse
            $httpCode = 200;
            $success = true;
            $icon = 'success';

            // Normalisation du statut
            $status = $result['status'] ?? 'failed';

            switch ($status) {
                case 'approved':
                case 'successful':
                case 'success':
                case 'completed': // Ajouté car présent dans votre service
                    $icon = 'success';
                    break;

                case 'pending':
                case 'pending_validation':
                case 'processing': // Ajouté
                    $icon = 'info';
                    break;

                case 'failed':
                case 'declined':
                case 'error':
                default:
                    $success = false;
                    $httpCode = 400; // Ou 422 selon votre logique
                    $icon = 'error';
                    break;
            }

            // 6. Extraction intelligente de l'URL de redirection
            $redirectUrl = null;

            // Priorité 1 : Lien direct retourné par le service (Cas Wave dans votre code)
            if (!empty($result['link'])) {
                $redirectUrl = $result['link'];
            }
            // Priorité 2 : Extraction depuis api_response (Cas Standards)
            elseif (!empty($result['api_response'])) {
                $redirectUrl = $result['api_response']['data']['payment_url']     // CinetPay / Hub2
                    ?? $result['api_response']['wave_launch_url']         // Wave (si structure différente)
                    ?? $result['api_response']['url']                     // Autres
                    ?? null;
            }

            // 7. Retour JSON
            return response()->json([
                'success'        => $success,
                'status'         => $status,
                'icon'           => $icon,
                'message'        => $result['message'] ?? 'Traitement en cours',
                // Utilisation de ?? null car en cas d'erreur le service ne renvoie pas toujours l'ID
                'transaction_id' => $result['transactions_id'] ?? $result['transaction_id'] ?? null,
                'redirect_url'   => $redirectUrl
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

    // Version de test pour Wave (Simule une réponse d'initiation sans appeler l'API)
    public function TestInitiatePaymentVote(Request $request)
    {
        try {
            // ID de transaction existant en BDD pour vos tests
            $transactionId = '493b578e-d357-4e3f-b86f-c94a80627029';
            $idCampagne = '29a4779e-5f0e-4539-8014-cbfcac327de5';

            // Utilisation du helper route() pour générer l'URL correcte
            // Attention aux noms des clés qui doivent matcher ceux de la route web.php
            // C'est le lien que vous avez reçu dans votre exemple
            // $waveLink = "https://pay.wave.com/c/cos-230jab3hr242p?a=100.00&c=XOF&m=TSIL%20%2A%20Paystack";
            $waveLink = "/business/wave_rollback/{$idCampagne}/{$transactionId}";

            return response()->json([
                'success' => true,
                'status'  => 'pending',
                'icon'    => 'info',
                'message' => 'Simulation Wave : Redirection...',
                'transaction_id' => $transactionId,
                'redirect_url' => $waveLink
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    //povider Orange Money (avec OTP)
    // public function TestInitiatePaymentVote(Request $request)
    // {

    //     try {

    //         $result = [
    //             'status' => 'pending',
    //             'message' => 'Simulation Locale : Initiation validée',
    //             'transactions_id' => '415c767b-4210-49ef-9158-25b505a3e6ac', // Ton ID existant
    //             'api_response' => ['data' => ['payment_url' => null]]
    //         ];

    //         return response()->json([
    //             'success' => true, // On force true pour que le JS lance le polling
    //             'status'  => $result['status'],
    //             'icon'    => 'info',
    //             'message' => $result['message'],
    //             'transaction_id' => $result['transactions_id'],
    //             'redirect_url' => null
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // ...
    //     }
    // }

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



    /**
     * PAGE DE RETOUR WAVE (ROLLBACK)
     * Correction des noms de variables pour compact()
     */
    public function waveRollback($idCampagne, $transactionId)
    {
        try {
            // compact() cherche des variables portant ces noms exacts ($idCampagne et $transactionId)
            return view('siteCampagne.partials.wave-return', compact('idCampagne', 'transactionId'));
        } catch (\Exception $e) {
            Log::error("Erreur Wave Rollback: " . $e->getMessage());
            abort(500, "Erreur lors du chargement de la page de retour.");
        }
    }
}
