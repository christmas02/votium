<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Console\ConsoleController;

use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\CampagneController;
use App\Http\Controllers\Business\CandidatController;
use App\Http\Controllers\Business\FinanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
Route::get('/', function () {
    return view('welcome');
});
*/


// ==========================================
// AUTHENTIFICATION
// ==========================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'screenLogin')->name('screenLogin');
    Route::post('registered', 'register');
    Route::post('login', 'login');
    Route::get('/confirm/{id}/{token}', 'confirm')->name('confirm');
    Route::get('logout', 'logout')->name('logout');
});


Route::group(['middleware' => 'auth'], function () {

    // ==========================================
    // CONSOLE (Admin)
    // ==========================================
    Route::prefix('console')
        ->name('console.')
        ->controller(ConsoleController::class)
        ->group(function () {
            Route::get('espace', 'index')->name('espace');

            // ROUTES PROFILE
            Route::get('profile', 'profile')->name('profile');
            Route::post('update_profile', 'updateProfile')->name('update_profile');

            // ROUTES CUSTOMERS
            Route::get('list_customer', 'listCustomer')->name('list_customer');
            Route::post('save_customer', 'saveCustomer')->name('save_customer');
            Route::delete('delete_customer', 'deleteCustomer')->name('delete_customer');
            Route::get('detail_customer/{idcustomer}', 'detailCustomer')->name('detail_customer');
            Route::get('editpassword_customer/{email}', 'editpasswordCustomer')->name('editpassword_customer');
            Route::post('updatepassword_customer', 'updatePasswordCustomer')->name('updatepassword_customer');

            //ROUTES CAMPAGNES
            Route::get('list_campagne', 'listCampagne')->name('list_campagne');
            Route::get('site_campagne/{idCampagne}', 'siteCampagne')->name('site_campagne');

            Route::post('save_campagne', 'saveCampagne')->name('save_campagne');
            Route::post('update_campagne', 'updateCampagne')->name('update_campagne');
            Route::delete('delete_campagne', 'deleteCampagne')->name('delete_campagne');
        });

    // ==========================================
    // BUSINESS (Espace Client)
    // ==========================================
    Route::prefix('business')
        ->name('business.')
        ->group(function () {

            // --- DASHBOARD ---
            Route::controller(BusinessController::class)->group(function () {
                Route::get('espace', 'index')->name('espace');

                # ROUTES PROFILE
                Route::get('profile', 'profile')->name('profile');
                Route::post('update_profile', 'updateProfile')->name('update_profile');

                # ROUTES CUSTOMERS
                Route::post('update_customer', 'updateCustomer')->name('update_customer');

                #ROUTE COMPTES RETRAITS
                Route::get('list_compte_retrait', 'listCompteRetrait')->name('list_compte_retrait');
                Route::post('save_compte_retrait', 'saveCompteRetrait')->name('save_compte_retrait');
                Route::post('update_compte_retrait', 'updateCompteRetrait')->name('update_compte_retrait');
                Route::post('delete_compte_retrait', 'deleteCompteRetrait')->name('delete_compte_retrait');
            });

            // --- CAMPAGNES (Principal) ---
            Route::controller(CampagneController::class)->group(function () {

                #ROUTES CAMPAGNES
                Route::get('list_campagne', 'listCampagne')->name('list_campagne');
                Route::get('site_campagne/{idCampagne}', 'siteCampagne')->name('site_campagne');
                Route::post('save_campagne', 'saveCampagne')->name('save_campagne');
                Route::post('update_campagne', 'updateCampagne')->name('update_campagne');
                Route::delete('delete_campagne', 'deleteCampagne')->name('delete_campagne');

                #ROUTES CATEGORIES CAMPAGNES
                Route::get('list_categorie/{campagne_id}', 'listCategorie')->name('list_categorie');
                Route::post('save_categorie', 'saveCategorie')->name('save_categorie');
                Route::post('update_categorie', 'updateCategorie')->name('update_categorie');
                Route::delete('delete_categorie', 'deleteCategorie')->name('delete_categorie');

                #ROUTES ETAPES CAMPAGNES
                Route::get('list_etape/{customer_id}/{campagne_id}', 'listEtape')->name('list_etape');
                Route::get('recherche_etape_campagne/{etape_id}', 'rechercheEtapeCampagne')->name('recherche_etape_campagne');
                Route::post('save_etape', 'saveEtape')->name('save_etape');
                Route::post('update_etape', 'updateEtape')->name('update_etape');
                Route::delete('delete_etape/{etape_id}', 'deleteEtape')->name('delete_etape');
            });

            // --- CANDIDATS ---
            Route::controller(CandidatController::class)->group(function () {
                #ROUTES CANDIDATS
                Route::get('list_candidat', 'listCandidat')->name('list_candidat');
                Route::get('detail_candidat/{idCandidat}', 'detailCandidat')->name('detail_candidat');
                Route::get('recherche_candidat', 'rechercheCandidat')->name('recherche_candidat');
                Route::post('save_candidat', 'saveCandidat')->name('save_candidat');
                Route::post('update_candidat', 'updateCandidat')->name('update_candidat');
                Route::delete('delete_candidat', 'deleteCandidat')->name('delete_candidat');
            });


            // --- FINANCES (Votes, Retraits, Transactions) ---
            Route::controller(FinanceController::class)->group(function () {

                #ROUTE POUR INITIER PAIEMENT VOTE
                Route::post('/paiement/initier', 'initiatePaymentVote')->name('paiementVote');

                #ROUTE POUR VERIFIER PAIEMENT VOTE
                Route::get('/paiement/verifier/{reference}', 'verifyPaymentVote')->name('payment.verify');

                #ROUTES VOTES
                Route::get('list_vote', 'listVote')->name('list_vote');

                #ROUTES RETRAITS
                Route::get('list_retrait', 'listRetrait')->name('list_retrait');
            });
        });
});
