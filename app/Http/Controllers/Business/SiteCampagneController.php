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

class SiteCampagneController extends Controller
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

        //Récupération des Candidats via le SERVICE
        $assignments = $this->CandidatureService->searchCandidat(['campagne_id' => $idCampagne]);

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
}
