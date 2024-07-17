<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CorporateProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ConsolidationController;
use App\Http\Controllers\ShareholderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Scraper;
use App\Http\Controllers\ClientCorporateProfileController;
use App\Http\Middleware\CheckUserLevel;
use App\Http\Controllers\Auth\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [CorporateProfileController::class, 'index'])->name('corporateProfileEn');
// Route::get('/', [CorporateProfileController::class, 'maintenanceMode'])->name('maintenanceMode');

Route::get('/chatbot', [App\Http\Controllers\ChatbotController::class, 'index']);
Route::get('/chatbot-corporate-profile', [App\Http\Controllers\ChatbotController::class, 'chatbotCorporateProfile']);
Route::post('chatbot', [App\Http\Controllers\ChatbotController::class, 'store'])->name('chatbot.store');
Route::get('chatbot2', [App\Http\Controllers\ChatbotController::class, 'store2'])->name('chatbot.store2');
Route::get('chatbot3', [App\Http\Controllers\ChatbotController::class, 'chats'])->name('chatbot3');
Route::post('chatbots', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chat');
Route::get('/chatbot4', [ChatbotController::class, 'chat4'])->name('chat4');
Route::post('/chatbot4', [ChatbotController::class, 'response'])->name('chatbot.response');
// Route::post('/chatbot/response', [ChatbotController::class, 'getResponse'])->name('chatbot.response');
Route::get('/eq-subsidiary', [ChatbotController::class, 'chatbotSubsidiaryId'])->name('chatbotSubsidiaryId');
Route::post('/eq-subsidiary', [ChatbotController::class, 'getSubsidiary'])->name('chatbot.subsidiary');
Route::get('/eq-group', [ChatbotController::class, 'chatbotGroupId'])->name('chatbotGroupId');
Route::post('/eq-group', [ChatbotController::class, 'getGroup'])->name('chatbot.group');
Route::get('/eq-subsidiary-en', [ChatbotController::class, 'chatbotSubsidiaryEn'])->name('chatbotSubsidiaryEn');
Route::post('/eq-subsidiary-en', [ChatbotController::class, 'getSubsidiaryEn'])->name('getSubsidiaryEn');
Route::get('/eq-group-en', [ChatbotController::class, 'chatbotGroupEn'])->name('chatbotGroupEn');
Route::post('/eq-group-en', [ChatbotController::class, 'getGroupEn'])->name('chatbotGroupEn');
// Testinggg

Route::get('/chatbot7', [ChatbotController::class, 'chatbot7'])->name('chatbot7');
Route::post('/chatbot7', [ChatbotController::class, 'getSubsidiary7'])->name('chatbot.subsidiary7');
Route::get('/chatbot6', [ChatbotController::class, 'chatbot6'])->name('chatbot6');
Route::post('/chatbot6', [ChatbotController::class, 'getResponse6'])->name('chatbot.process');

Route::get('/shareholder/{name}', [ChatbotController::class, 'showShareholder'])->name('shareholder');
Route::get('/company/{subsidiary}', [ChatbotController::class, 'company'])->name('company');
// Route::get('/shareholder/{name}', 'ShareholderController@show')->name('shareholder');

// Route::get('/shareholder/{name}', 'ShareholderController@show')
// Route::get('/shareholder/{name}', 'ShareholderController@show');


// Route::post('/chatbot', 'ChatbotController@chat');

Route::get('/import-csv', [ChatbotController::class, 'importCsvForm'])->name('importCsvForm');
Route::post('/import-csv', [ChatbotController::class, 'importCsv'])->name('importCsv');
Route::get('/import-csv-consolidation', [ChatbotController::class, 'importCsvFormConsolidation'])->name('importCsvFormConsolidation');
Route::post('/import-csv-consolidation', [ChatbotController::class, 'importCsvConsolidation'])->name('importCsvConsolidation');
Route::get('/export', [App\Http\Controllers\ChatbotController::class, 'export']);

// Website corporate profile
// Route::get('/corporate-profile-en', [CorporateProfileController::class, 'index'])->name('corporateProfileEn');
// Route::get('/corporate-profile-index', [CorporateProfileController::class, 'index'])->name('index');
Route::post('/corporate-profile-subsidiary-show', [CorporateProfileController::class, 'subsidiaryShow'])->name('subsidiaryShow');
Route::post('/corporate-profile-other-company-show', [CorporateProfileController::class, 'otherCompanyShow'])->name('otherCompanyShow');
Route::post('/corporate-profile-group-show', [CorporateProfileController::class, 'groupShow'])->name('groupShow');
Route::post('/corporate-profile-group2-show', [GroupController::class, 'group2Show'])->name('group2Show');
Route::post('/corporate-profile-sra-show', [CorporateProfileController::class, 'sraShow'])->name('sraShow');
Route::post('/corporate-profile-shareholder-show', [CorporateProfileController::class, 'shareholderShow'])->name('shareholderShow');


// Scraperss 
// Route::get('/scrape', 'ScraperController@scrape');
Route::get('/scrape', [ScraperController::class, 'index'])->name('scrape');
// Route::get('/scrape', function () {
//     $scraper = new Scraper();
//     $scraper->scrape();

//     return 'Scraping completed';
// });
Route::get('/search-groups', [CorporateProfileController::class, 'searchFunctionGroup'])->name('searchFunctionGroup');
Route::get('/search-groups2', [CorporateProfileController::class, 'searchFunctionGroup2'])->name('searchFunctionGroup2');
Route::get('/search-subsidiaries', [CorporateProfileController::class, 'searchFunctionSubsidiary'])->name('searchFunctionSubsidiary');
Route::get('/search-other-companies', [CorporateProfileController::class, 'searchFunctionOtherCompany'])->name('searchFunctionOtherCompany');
Route::get('/search-shareholders', [CorporateProfileController::class, 'searchFunctionShareholder'])->name('searchFunctionShareholder');
Route::get('/search-sra', [CorporateProfileController::class, 'searchFunctionSRA'])->name('searchFunctionSRA');

Route::get('/features', [CorporateProfileController::class, 'feature'])->name('feature');
Route::get('/group-feature', [FeatureController::class, 'groupFeature'])->name('groupFeature');
Route::get('/subsidiary-feature', [FeatureController::class, 'subsidiaryFeature'])->name('subsidiaryFeature');
Route::get('/shareholder-feature', [FeatureController::class, 'shareholderFeature'])->name('shareholderFeature');
Route::get('/sra-feature', [FeatureController::class, 'sraFeature'])->name('sraFeature');

Route::get('/faqs', [FaqController::class, 'faq'])->name('faq');
Route::resources([
    'faq' => FaqController::class,
]);

Route::get('/term-of-services', [CorporateProfileController::class, 'termOfServices'])->name('termOfServices');
Route::get('/privacy-and-policy', [CorporateProfileController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/user-guide', [CorporateProfileController::class, 'userGuide'])->name('userGuide');

Route::get('/search', [CorporateProfileController::class, 'search'])->name('search');
Route::get('/maps', [CorporateProfileController::class, 'maps'])->name('maps');
Route::post('/maps', [CorporateProfileController::class, 'maps'])->name('maps');

Route::get('/scraping', [CorporateProfileController::class, 'scrapingLatLong'])->name('scrapingLatLong');
Route::get('/wef', [CorporateProfileController::class, 'wef'])->name('wef');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Route for client
// Route::prefix('client')->group(function () {
//     // Rute-rute yang memiliki prefix 'client'
//     Route::get('/corporate-profile-en', [ClientCorporateProfileController::class, 'index'])->name('index');
//     Route::get('/subsidiary', [ClientCorporateProfileController::class, 'subsidiaryShow'])->name('subsidiaryShow');
//     Route::get('/group', [ClientCorporateProfileController::class, 'groupShow'])->name('groupShow');
// });
// // End route for client 

// Role 
// Route untuk user 1 (admin) yang harus login untuk mengakses dashboard
Route::middleware('auth')->group(function () {
    // Tambahkan route untuk mengelola dashboard dan konten lainnya di sini
});

// Route untuk user 2 yang tidak perlu login
Route::get('/halaman-tertentu', function () {
    // Logika untuk halaman dengan batasan tertentu
    return "User";
});

// // Route untuk user 3 yang login level 1
// Route::middleware(CheckUserLevel::class . ':Standard')->group(function () {
//     // Tambahkan route untuk fitur tertentu yang hanya bisa diakses oleh user 3
//     Route::get('/standard', function () {
//         return 'Hello client standard, this is a route without a controller!';
//     });
// });

// // Route untuk user 4 yang login level 2
// Route::middleware(CheckUserLevel::class . ':Advanced')->group(function () {
//     // Tambahkan route untuk fitur tertentu yang hanya bisa diakses oleh user 4
//     Route::get('/advanced', function () {
//         return 'Hello client advanced, this is a route without a controller!';
//     });
// });

// Route untuk user 1 yang login sebagai admin dan dapat mengelola dashboard
Route::middleware(['auth', CheckUserLevel::class . ':Admin'])->group(function () {
    // Tambahkan route untuk mengelola dashboard dan konten lainnya di sini
});

// Route untuk user 3 yang login level 1
Route::middleware(['auth', CheckUserLevel::class . ':Standard'])->group(function () {
    // Tambahkan route untuk fitur tertentu yang hanya bisa diakses oleh user 3
});

// Route untuk user 4 yang login level 2
Route::middleware(['auth', CheckUserLevel::class . ':Premium'])->group(function () {
    // Tambahkan route untuk fitur tertentu yang hanya bisa diakses oleh user 4
});

// // Route untuk user 2 yang tidak perlu login tapi memiliki akses terbatas
// Route::get('/limited-access', function () {
//     return 'Hello user with limited access!';
// });

// Route untuk user 2 yang tidak perlu login tapi memiliki akses terbatas
Route::middleware([CheckUserLevel::class . ':Basic'])->group(function () {
    Route::get('/limited-access', function () {
        return 'Hello user with limited access!';
    });
});

Route::get('/subsidiary', [CorporateProfileController::class, 'subsidiaryList']);
Route::get('/subsidiary/{id}', [CorporateProfileController::class, 'subsidiaryShow']);
Route::get('/auth/google/callback', [CorporateProfileController::class, 'handleCallback']);


Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::get('/dashboard-inbox', [AdminController::class, 'inbox'])->name('inbox');

// Contoh menggunakan Controller sebagai parameter
Route::resources([
    'groups' => GroupController::class,
]);
Route::resources([
    'consolidations' => ConsolidationController::class,
]);
Route::resources([
    'shareholders' => ShareholderController::class,
]);
Route::resources([
    'messages' => MessageController::class,
]);
Route::post('/messages', [CorporateProfileController::class, 'store'])->name('messages.store');