<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@creditor');

Route::get('/Collector','Accounting\MainController@collector');
Route::get('/AddCollector','Accounting\MainController@addCollector');
Route::post('/AddCollector','Accounting\MainController@saveCollector');
Route::get('/EditCollector/{collectorID}','Accounting\MainController@editCollector');
Route::post('/EditCollector/{collectorID}','Accounting\MainController@editCollector');
Route::post('/DelCollector/{collectorID}','Accounting\MainController@delCollector');

Route::get('/Sales','Accounting\MainController@sales');
Route::get('/AddSales','Accounting\MainController@addSales');
Route::post('/AddSales','Accounting\MainController@saveSales');
Route::get('/EditSales/{salesID}','Accounting\MainController@editSales');
Route::post('/EditSales/{salesID}','Accounting\MainController@editSales');
Route::post('/DelSales/{salesID}','Accounting\MainController@delSales');

Route::get('/PaymentType','Accounting\MainController@paymentType');
Route::get('/AddPaymentType','Accounting\MainController@addPaymentType');
Route::post('/AddPaymentType','Accounting\MainController@savePaymentType');
Route::get('/EditPaymentType/{paymentTypeID}','Accounting\MainController@editPaymentType');
Route::post('/EditPaymentType/{paymentTypeID}','Accounting\MainController@editPaymentType');
Route::post('/DelPaymentType/{paymentTypeID}','Accounting\MainController@delPaymentType');

Route::get('/Status','Accounting\MainController@status');
Route::get('/AddStatus','Accounting\MainController@addStatus');
Route::post('/AddStatus','Accounting\MainController@saveStatus');
Route::get('/EditStatus/{statusID}','Accounting\MainController@editStatus');
Route::post('/EditStatus/{statusID}','Accounting\MainController@editStatus');
Route::post('/DelStatus/{statusID}','Accounting\MainController@delStatus');

Route::get('/Creditor','Accounting\MainController@creditor');
Route::get('/AddCreditor','Accounting\MainController@addCreditor');
Route::get('/GetCreditorID','Accounting\MainController@GetCreditorID');
Route::post('/AddCreditor','Accounting\MainController@saveCreditor');
Route::get('/EditCreditor/{creditorID}','Accounting\MainController@editCreditor');
Route::post('/EditCreditor/{creditorID}','Accounting\MainController@editCreditor');
Route::post('/DelCreditor/{creditorID}','Accounting\MainController@delCreditor');

Route::get('/Debtor','Accounting\MainController@debtor');
Route::get('/AddDebtor','Accounting\MainController@addDebtor');
Route::get('/AddDebtor/{DID}','Accounting\MainController@addDebtor');
Route::get('/GetContact','Accounting\MainController@getContact');
Route::get('/EditDebtor/GetContact','Accounting\MainController@getContact');
Route::post('/AddDebtor','Accounting\MainController@saveDebtor');
Route::get('/EditDebtor/{DebtorID}','Accounting\MainController@editDebtor');
Route::post('/EditDebtor/{DebtorID}','Accounting\MainController@editDebtor');
Route::post('/DelAttorney/{DebtorID}','Accounting\MainController@delAttorney');
Route::post('/DelDebtor/{DebtorID}','Accounting\MainController@delDebtor');
Route::get('/Letters/{DebtorID}','Accounting\MainController@lettersDebtor');
Route::post('/Letters/{DebtorID}','Accounting\MainController@PrintTemplate');
Route::post('/print','Accounting\MainController@saveWord');
Route::post('/AddNote','Accounting\MainController@saveNote');
Route::post('/DelNote/{DebtorID}','Accounting\MainController@delNote');
Route::post('/AddActivityCode','Accounting\MainController@saveActivityCode');
Route::post('/DelActivityCode/{DebtorID}','Accounting\MainController@delActivityCode');
Route::post('/UploadFile/{DebtorID}','Accounting\MainController@UploadFile');
Route::get('/Donwload/{FileID}','Accounting\MainController@DonwloadFile');
Route::get('/calculationDebit/{DebtorID}','Accounting\MainController@calculationDebit');

Route::get('/Contacts/{creditorID}','Accounting\MainController@contacts');
Route::get('/Contact','Accounting\MainController@contact');
Route::get('/AddContact','Accounting\MainController@addcontact');
Route::get('/EditContact/{contactID}','Accounting\MainController@editcontact');
Route::get('/EditContact/{contactID}/{CreditorID}','Accounting\MainController@editcontact');
Route::post('/EditContact/{contactID}','Accounting\MainController@editcontact');
Route::post('/EditContact/{contactID}/{CreditorID}','Accounting\MainController@editcontact');
Route::post('/AddContact','Accounting\MainController@savecontact');
Route::post('/DelContact/{contactID}','Accounting\MainController@delcontact');


Route::get('/TrustAccount/{DebtorID}','Accounting\MainController@trustAccount');
Route::get('/AddTrustActivity/{DebtorID}','Accounting\MainController@addTrustActivity');
Route::post('/AddTrustActivity/{DebtorID}','Accounting\MainController@saveTrustActivity');
Route::get('/EditTrustActivity/{TPaymentID}','Accounting\MainController@editTrust');
Route::post('/EditTrustActivity/{TPaymentID}','Accounting\MainController@editTrust');
Route::post('/DelTrustActivity/{TPaymentID}','Accounting\MainController@delTrust');

Route::get('/Invoices/{DebtorID}','Accounting\MainController@invoices');
Route::get('/UnpaidInvoices','Accounting\MainController@unpaidInvoices');
Route::post('/UnpaidInvoices/{InvoiceNumb}','Accounting\MainController@paidInvoice');
Route::get('/AddCredit/{DebtorID}','Accounting\MainController@addCredit');
Route::post('/AddCredit/{DebtorID}','Accounting\MainController@saveCredit');

Route::get('/AddInvoice/{TPaymentID}','Accounting\MainController@addInvoice');
Route::Post('/AddInvoice/{TPaymentID}','Accounting\MainController@saveInvoice');
Route::get('/ShowInvoice/{TPaymentID}','Accounting\MainController@ShowInvoice');
Route::get('/EditInvoice/{TPaymentID}','Accounting\MainController@EditInvoice');
Route::Post('/EditInvoice/{TPaymentID}','Accounting\MainController@EditInvoice');
Route::get('/DeleteInvoice/{ID}','Accounting\MainController@DeleteInvoice');
Route::Post('/UpdatePaidInvoice/{IPaymentID}','Accounting\MainController@updatePaidInvoice');

Route::get('/DebtorBySalemanReports','Accounting\MainController@DebtorBySalemanReports');
Route::post('/DebtorBySalemanReports','Accounting\MainController@showDebtorBySalemanReports');
Route::get('/DebtorReports','Accounting\MainController@DebtorReports');
Route::Post('/DebtorReports','Accounting\MainController@showDebtorReports');
Route::get('/CreditorReports','Accounting\MainController@CreditorReports');
Route::Post('/CreditorReports','Accounting\MainController@showCreditorReports');
Route::get('/TrustReports','Accounting\MainController@TrustReports');
Route::Post('/TrustReports','Accounting\MainController@showTrustReports');
Route::get('/InvoiceReports','Accounting\MainController@InvoiceReports');
Route::Post('/InvoiceReports','Accounting\MainController@showInvoiceReports');
Route::get('/CreditorsSummary/{creditorID}','Accounting\MainController@CreditorsSummary');
Route::post('/CreditorsSummary/{creditorID}','Accounting\MainController@ShowCreditorsSummary');
Route::get('/ImportExport','Accounting\MainController@ImportExport');
Route::post('/ImportExport','Accounting\MainController@postUploadCsv');

Route::get('/Template','Accounting\MainController@Template');
Route::get('/AddTemplate','Accounting\MainController@AddTemplate');
Route::post('/AddTemplate','Accounting\MainController@SaveTemplate');
Route::get('/EditTemplate/{TemplateID}','Accounting\MainController@EditTemplate');
Route::post('/EditTemplate/{TemplateID}','Accounting\MainController@UpdateTemplate');
Route::get('/DelTemplate/{TemplateID}','Accounting\MainController@DelTemplate');
Route::post('/PrintTemplate','Accounting\MainController@PrintTemplate');

Route::get('/Rights','Accounting\MainController@Rights');
Route::post('/Rights','Accounting\MainController@SaveRights');
Route::get('/RightsFields','Accounting\MainController@RightsFields');
Route::post('/RightsFields','Accounting\MainController@updateRightsFields');
Route::post('/RightsFieldsConfig','Accounting\MainController@RightsFieldsConfig');

Route::get('/ClientPortal','Accounting\ClientController@ClientPortal');
Route::get('/ClientTrustReport','Accounting\ClientController@TrustReports');
Route::Post('/ClientTrustReport','Accounting\ClientController@showTrustReports');
Route::get('/ClientInvoiceReport','Accounting\ClientController@InvoiceReports');
Route::Post('/ClientInvoiceReport','Accounting\ClientController@showInvoiceReports');
Route::get('/StatusReport','Accounting\ClientController@CreditorsSummary');
Route::Post('/StatusReport','Accounting\ClientController@ShowCreditorsSummary');

Route::get('/Users','Accounting\MainController@Users');
Route::get('/AddUser','Accounting\MainController@addUser');
Route::post('/AddUser','Accounting\MainController@saveUser');
Route::post('/AddUserCreditor','Accounting\MainController@saveUserCreditor');
Route::get('/GetUserCreditor','Accounting\MainController@GetUserCreditor');
Route::get('/DeleteUserCreditor','Accounting\MainController@DeleteUserCreditor');

Route::get('/editUser/{id}','Accounting\MainController@editUser');
Route::post('/editUser/{id}','Accounting\MainController@editUser');
Route::get('/deleteUser','Accounting\MainController@deleteUser');

Route::get('/globalSearch','Accounting\ClientController@globalSearch');
Route::get('/loadProfile','Accounting\ClientController@loadProfile');