<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\Login;
use App\Http\Controllers\AdminProfile;
use App\http\Controllers\ReportUpload;
use App\http\Controllers\SubEditor;
use App\http\Controllers\User;
use App\http\Controllers\Publication;
use App\http\Controllers\Edition;
use App\http\Controllers\Supplement;
use App\http\Controllers\Journalist;
use App\http\Controllers\Sector;
use App\http\Controllers\Product;
use App\http\Controllers\NewsCity;
use App\http\Controllers\AllCategories;
use App\http\Controllers\CheckEdition;
// use App\http\Controllers\NewsLetterPreview;
use App\http\Controllers\SovProcess;
use App\http\Controllers\HardCopy;
use App\http\Controllers\MarketWatch;
use App\http\Controllers\ProductPurchasesService;
use App\http\Controllers\ProductUsers;
use App\http\Controllers\Competition;
use App\http\Controllers\UserType;
use App\http\Controllers\ReporterController;
use App\http\Controllers\ClientController;
use App\http\Controllers\NewsLatterController;
use App\http\Controllers\IndustryController;
use App\http\Controllers\DashboardController;
use App\http\Controllers\CompareChartConteoller;
use App\http\Controllers\ReportController;
use App\http\Controllers\NewsUpload;
use App\http\Controllers\AddRate;
use App\http\Controllers\reporterAccount;
use App\http\Controllers\addClientTemplate;
use App\http\Controllers\NewsArtical;
use App\http\Controllers\ClientDashboard\ClientLogin;
use App\http\Controllers\ClientDashboard\ganerateReport;
use App\http\Controllers\ClientDashboard\ProCompare;
use App\http\Controllers\ClientDashboard\ProAnalytics;
// Route::get('/', function () {
//     return view('welcome');
// });  

//this routes for the client dashboard login 
Route::get('/admin-login', [ClientLogin::class, 'index'])->name('ClientLogin');
Route::post('/admin-logout', [ClientLogin::class, 'Logout'])->name('logout.client');
Route::post('/login-client', [ClientLogin::class, 'loginClient'])->name('login.client');
//this is for the Pro Report funcationality 
Route::get('/generate-report', [ganerateReport::class, 'index'])->name('generateReport');
// Download pdf and word file funcationality 
Route::post('/get-news-pdf', [ganerateReport::class, 'getNewsArticleData'])->name('getNewsArticleData');
Route::post('/get-news-word', [ganerateReport::class, 'getNewsArticleInword'])->name('getNewsArticleInWord');

Route::post('/get-news-word', [ganerateReport::class, 'getNewsArticleInword'])->name('getNewsArticleInWord');

Route::get('/pro-compare-charts', [ProCompare::class, 'index'])->name('charts.ProCompare');
// Route::post('/get-pro-compare-charts', [ProCompare::class, 'fetchClientData']);
Route::post('/fetchClientData', [ProCompare::class, 'fetchClientData'])->name('fetchClientData');
Route::get('/pro-analytics-charts', [ProAnalytics::class, 'index'])->name('charts.ProAnalytics');
Route::post('/fetchAnalyticsData', [ProAnalytics::class, 'fetchAnalyticsData'])->name('fetchAnalyticsData');


Route::get('/', [Login::class, 'index'])->name('login');
Route::post('/login', [Login::class, 'loginUser'])->name('login.user');
Route::post('/logout', [Login::class, 'userLogout'])->name('logout.user');
Route::post('/check-user-mail', [Login::class, 'checkUserMail'])->name('check.userMail');
Route::post('/forgot-password', [Login::class, 'forgotPassword'])->name('user.sendForgotPasswordMail');

Route::get('/NewsUpload', [NewsUpload::class, 'index'])->name('news_upload');
Route::post('/NewsUpload/saveArticalImage', [NewsUpload::class, 'saveArticalImage'])->name('newsUpload.saveArticalImage');
Route::post('/NewsUpload/search-Keywords', [NewsUpload::class, 'searchKeywords'])->name('newsUpload.searchKeywords');
Route::post('/NewsUpload/get-Clients-From-Keywords', [NewsUpload::class, 'getClientsFromKeywords'])->name('newsUpload.getClientsFromKeywords');
Route::post('/NewsUpload/get-Compitetors-From-Clients', [NewsUpload::class, 'getCompitetorsFromClients'])->name('newsUpload.getCompitetorsFromClients');
Route::post('/NewsUpload/add', [NewsUpload::class, 'store'])->name('newsUpload.store');

// Admin Route 
Route::get('/reporter-account', [reporterAccount::class, 'index'])->name('reporte.account');
Route::post('/update-reporter-password', [reporterAccount::class, 'updateReporterPassword'])->name('reporter.updateReporterPassword');
Route::post('/update-reporter-information', [ReporterAccount::class, 'updateReporterInformation'])->name('reporter.updateReporterInformation');


// Admin Profile Route
Route::get('/Profile', [AdminProfile::class, 'Profile'])->name('Profile');


//Reporter upload 
Route::get('/report_upload', [ReportUpload::class, 'report_upload'])->name('report_upload');
// Route::get('/ReportUpload', [ReportUpload::class, 'index'])->name('report_upload');

//Reporter upload 
Route::post('/addArtical', [ReportUpload::class, 'addArtical'])->name('add_artical');
// Route::get('/ReportUpload', [ReportUpload::class, 'index'])->name('report_upload');

//Reporter Routs
Route::get('/repoter', [ReporterController::class, 'index'])->name('repoter');
Route::post('/reporter/add', [ReporterController::class, 'store'])->name('reporter.store');
Route::post('/reporter/update/{id}', [ReporterController::class, 'update'])->name('reporter.update');
Route::get('/reporter/resetPassword/{id}/{token}', [ReporterController::class, 'resetPassword'])->name('reporter.resetPassword');
Route::post('/reporter/updatePassword/', [ReporterController::class, 'updatePassword'])->name('reporter.updatePassword');

Route::get('/client', [ClientController::class, 'index'])->name('client');
Route::post('/client/add', [ClientController::class, 'store'])->name('client.store');
Route::post('/client/addCompetitor', [ClientController::class, 'addCompetitor'])->name('client.addCompetitor');
Route::post('/add-users-email', [ClientController::class, 'addUsersEmail'])->name('addUsersEmail');
Route::get('/ganerate-users-password/{id}/{token}', [ClientController::class, 'ganerateUserPassword'])->name('user.ganeratePassword');
Route::post('setPassword/', [ClientController::class, 'setPassword'])->name('admin.setPassword');

// Route::get('/addTemplate', [addClientTemplate::class, 'addNewsTemplate'])->name('addNewsTemplate');
Route::get('/add-news-template/{client_id}', [addClientTemplate::class, 'addNewsTemplate'])->name('addNewsTemplate');
Route::post('/addTemplate/add', [addClientTemplate::class, 'store'])->name('addNewsTemplate.store');

Route::get('/newsLatter-list', [NewsLatterController::class, 'CompanyNewsLetterList'])->name('news_latter');

Route::get('/news_latter/{client_id}', [NewsLatterController::class, 'newsLatter'])->name('newsLatter');
Route::post('/update-news', [NewsLatterController::class, 'update'])->name('updateNews');
Route::post('/update-news-data', [NewsLatterController::class, 'updateNewsofCompIndu'])->name('updateNewsofCompIndu');
Route::post('/delete-news', [NewsLatterController::class, 'deleteNews'])->name('deleteNews');

Route::post('/get-emails', [NewsLatterController::class, 'getEmail'])->name('getEmail'); 
Route::post('/send-News', [NewsLatterController::class, 'sendEmail'])->name('sendEmail'); 
Route::post('/send-News-with-Template', [NewsLatterController::class, 'sendEmailWithTemplate'])->name('sendEmailWithTemplate'); 

Route::get('/news-article/{news_details_id}', [NewsArtical::class, 'index'])->name('NewsArtical');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/compare_charts',[CompareChartConteoller::class, 'index'])->name('compare_charts');

//Reporter upload 


Route::get('/reporterOldUpload', [ReportUpload::class, 'reporterOldUpload'])->name('old_report_upload');

//subEditor
Route::get('/SubEditor', [SubEditor::class, 'index'])->name('sub_editor');

//users
//user Type

Route::get('/UserType', [UserType::class, 'index'])->name('user_type');
//add user Type

//add user Type
Route::post('/AddUserType', [UserType::class, 'AddUserType'])->name('add_userType');
//edit user Type
Route::post('/editUserType', [UserType::class, 'editUserType'])->name('edit_userType');
//Delete user Type
Route::post('/deleteUserType', [UserType::class, 'deleteUserType'])->name('delete_userType');
 

//user
Route::get('/Users', [User::class, 'index'])->name('all_user');

Route::get('/industry', [IndustryController::class, 'index'])->name('industry');
Route::post('/industry/add', [IndustryController::class, 'store'])->name('Industry.store');
Route::post('/industry/update/{id}', [IndustryController::class, 'update'])->name('industry.update');
//Publication
Route::get('/Publication', [Publication::class, 'index'])->name('publication');
Route::post('/Publication/add', [Publication::class, 'store'])->name('publication.store');
Route::post('/Publication/update/{id}', [Publication::class, 'update'])->name('Publication.update');

//Edition
Route::get('/Edition', [Edition::class, 'index'])->name('edition');
Route::post('/Edition/add', [Edition::class, 'store'])->name('edition.store');
Route::post('/Edition/update/{id}', [Edition::class, 'update'])->name('edition.update');

//user
Route::get('/Supplement', [Supplement::class, 'index'])->name('supplement');
Route::post('/Supplement/add', [Supplement::class, 'store'])->name('supplement.store');
Route::post('/Supplement/update/{id}', [Supplement::class, 'update'])->name('Supplement.update');
Route::post('/Supplement/getEdition', [Supplement::class, 'getEdition'])->name('supplements.getEditionByPublication');

//user
Route::get('/Journalist', [Journalist::class, 'index'])->name('journalist');
Route::post('/journalist/add', [Journalist::class, 'store'])->name('journalist.store');
Route::post('/journalist/update/{id}', [Journalist::class, 'update'])->name('journalist.update');

//sector
Route::get('/Sector', [Sector::class, 'index'])->name('sector');
//sector
Route::get('/Product', [Product::class, 'index'])->name('product');

//sector
Route::get('/NewsCity', [NewsCity::class, 'index'])->name('news_city');



//Categories 
// This route is for showing categories page 
Route::get('/AllCategories', [AllCategories::class, 'index'])->name('all_categories');
// This route is for add Keywords page which perform on the click of keywords link from All categories page 
Route::get('/addKeywords', [AllCategories::class, 'addKeywords'])->name('add_keywords');
// This route is for add Keywords page which perform on the click of keywords link from All categories page 
Route::get('/product_purches_service', [ProductPurchasesService::class, 'index'])->name('product_purches_service');

// This route is for add Keywords page which perform on the click of keywords link from All categories page 
Route::get('/product_users', [ProductUsers::class, 'index'])->name('product_users');

// This route is for add Keywords page which perform on the click of keywords link from All categories page 
Route::get('/competition', [Competition::class, 'index'])->name('competition');

//sector
Route::get('/CheckEdition', [CheckEdition::class, 'index'])->name('check-edition');

//sector
Route::get('/AddRate', [AddRate::class, 'index'])->name('addRate');
Route::post('/AddRate/add', [AddRate::class, 'store'])->name('addRate.store');
Route::post('/AddRate/update/{id}', [AddRate::class, 'update'])->name('AddRate.update');

Route::post('/get-DataByMedia', [AddRate::class, 'getDataByMedia'])->name('getDataByMedia');
Route::post('/get-publication', [AddRate::class, 'getPublication'])->name('getPublication');
Route::post('/get-edition', [AddRate::class, 'getEdition'])->name('getEdition');
Route::post('/get-edition-Journalist', [NewsUpload::class, 'getEditionAndJournalist'])->name('getEditionAndJournalist');
Route::post('/get-supplement', [AddRate::class, 'getSupplement'])->name('getSupplement');
//sector
Route::get('/SovProcess', [SovProcess::class, 'index'])->name('sov_process');

//sector
Route::get('/HardCopy', [HardCopy::class, 'index'])->name('hard_copy');

//sector
Route::get('/MarketWatch', [MarketWatch::class, 'index'])->name('market_watch');
 

