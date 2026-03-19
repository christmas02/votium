<?php

namespace App\Http\Controllers\Business;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampagneRequest;
use App\Http\Requests\CandidatRequest;
use App\Http\Requests\CategoryCampagneRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\EtapeRequest;
use App\Http\Requests\RetraitRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\WithdrawalAccountRequest;
use App\Models\Campagne;
use App\Models\Customer;
use App\Models\Etape;
use App\Models\User;
use App\Models\Vote;
use App\Services\CampagneService;
use App\Services\CandidatureService;
use App\Services\CustomerService;
use App\Services\Files;
use App\Services\SendMail;
use App\Services\Setting;
use App\Services\VoteService;
use App\Services\RetraitService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class RetraitController extends Controller
{
    protected CustomerService $CustomerService;
    protected CampagneService $CampagneService;
    protected CandidatureService $CandidatureService;
    protected VoteService $VoteService;
    protected RetraitService $RetraitService;
    protected Setting $setting;
    protected Files $files;

    public function __construct(
        CustomerService $CustomerService,
        CampagneService $CampagneService,
        CandidatureService $CandidatureService,
        VoteService $VoteService,
        RetraitService $RetraitService,
        Setting $setting,
        Files $files
    ) {
        $this->CustomerService = $CustomerService;
        $this->CampagneService = $CampagneService;
        $this->CandidatureService = $CandidatureService;
        $this->VoteService = $VoteService;
        $this->RetraitService = $RetraitService;
        $this->setting = $setting;
        $this->files = $files;
    }

    #RETRAITS
    public function listRetrait()
    {
        $title_back = "Tableau de bord";
        $link_back = "list_retrait";
        $title = "Liste retraits";

        $customer_id = auth()->user()->customer->customer_id;

        #Recupérer les comptes de retrait du client connecté
        $compteRetraits = $this->CustomerService->listWithdrawalAccountByCustomer($customer_id);
        
        #Recupérer accounts by customer
        $account = $this->CustomerService->getAccountByCustomer($customer_id);

        #Liste des retraits du client connecté
        $retraits = $this->RetraitService->listeRetraitByCustomer($customer_id);
        // dd($retraits);
        return view('business.listRetraits', compact('title', 'title_back', 'link_back', 'compteRetraits', 'account', 'retraits'));
    }

    #  DEMANDES DE RETRAITS
    public function DemandeRetrait(RetraitRequest $request)
    {
        try {
            #Formatage des données
            $data = [
                'customer_id' => $request->customer_id,
                'destination' => $request->destination,
                'montant' => $request->montant,
                'motif' => $request->motif,
            ];

            $result = $this->RetraitService->createRetrait($data);
            return redirect()->back()->with('success', 'Demande de retrait créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Error creating withdrawal request: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de la demande de retrait.');
        }
    }
}
