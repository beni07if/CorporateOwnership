<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CorporateProfileController;
use App\Http\Controllers\Scraper;

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

Route::get('/', function () {
    return view('welcome');
});

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
Route::get('/corporate-profile-en', [CorporateProfileController::class, 'index'])->name('corporateProfileEn');
Route::get('/corporate-profile-index', [CorporateProfileController::class, 'index'])->name('index');
// Route::get('/corporate-profile-subsidiary-show', [CorporateProfileController::class, 'subsidiaryShow'])->name('subsidiaryShow');
Route::post('/corporate-profile-subsidiary-show', [CorporateProfileController::class, 'subsidiaryShow'])->name('subsidiaryShow');


// Scraperss 
// Route::get('/scrape', 'ScraperController@scrape');
Route::get('/scrape', [ScraperController::class, 'index'])->name('scrape');
// Route::get('/scrape', function () {
//     $scraper = new Scraper();
//     $scraper->scrape();

//     return 'Scraping completed';
// });
Route::get('/search', [CorporateProfileController::class, 'search'])->name('search');
Route::get('/maps', [CorporateProfileController::class, 'maps'])->name('maps');
Route::post('/maps', [CorporateProfileController::class, 'maps'])->name('maps');
