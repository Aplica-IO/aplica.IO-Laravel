<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user-profile', 'AuthController@userProfile');
});
# Routes for forget password and password recovery
Route::post('forget-password', 'Auth\AuthController@forget');
Route::post('reset-password', 'Auth\AuthController@resetPassword');

# Group routes for the Auth Model methods.
// Route::prefix('auth')->group(function () {
// 	Route::post('login', 'Auth\AuthController@login'); //Correct
// 	Route::post('register', 'Auth\AuthController@register'); //Correct
// 	Route::post('logout', 'Auth\AuthController@logout'); //Correct
// });

# Group routes for the resource methods models
Route::prefix('')->group(function () {
    // Send invitation for properties.
    Route::post('invitation', 'User\UserController@invite');
	// Store Personal Charges to some properties
    Route::post('storePersonalCharges', 'Charge\ChargeController@storePersonalCharges');
	
	Route::apiResource('address', 'Geolocation\GeolocationController');
	Route::apiResource('users', 'User\UserController');
	Route::apiResource('residence', 'Residence\ResidenceController');//index.correct\\//show.correct\\//store.correct\\//update.correct\\//delete.correct\\
	//Error en store.property, campo mal escrito, residences, plural en vez de singular.
	Route::apiResource('property', 'Property\PropertyController');//show.correct\\//index.correct\\//store.correct\\//update.correct\\//delete.correct\\
	Route::apiResource('invoice', 'Invoice\InvoiceController'); //index.correct\\//store.correct\\//delete.correct\\//update.correct\\//show.correct\\
	//Cambiar la relacion invoice->payments a property->payments
	//Corregir errores de relaciones en show.charge invoice.bad
	Route::apiResource('charge', 'Charge\ChargeController');//index.incorrect//store.correct\\//show.correct\\//update.correct\\//delete.correct\\
	Route::apiResource('payment', 'Payment\PaymentController');//index.correct//show.correct//store.correct\\//mid.update\\//delete.correct\\
	// Return all the properties of an user.
	Route::get('property-user/{id}', 'Property\PropertyController@showThroughUser'); //Correct//
	// Return a property with their payments
	Route::get('property-payment/{id}', 'Payment\PaymentController@showThroughProperty');//Correct//
	// Make new residence with address
	Route::post('new-residence', 'Residence\ResidenceController@createResidenceWithAddress'); //Correct//
	// Return all residences of an Auditor
	Route::get('residence-auditor/{id}', 'Residence\ResidenceController@getResidencesThroughUser'); //Correct//
	// Return all properties in a Residence
	Route::get('property-residence/{id}', 'Property\PropertyController@showThroughResidence'); //Correct//
	// Return the last invoice of a residence
	Route::get('last-invoice/{id}', 'Invoice\InvoiceController@getLastOne');//Correct//
	// Return all invoices in a residence
	Route::get('invoice-residence/{id}', 'Invoice\InvoiceController@showThroughResidence');//Correct//
	// Return inactive invoices
	Route::get('inactive-invoices/', 'Invoice\InvoiceController@InactiveInvoices');//Correct//
	// Return all charges in a invoice
	Route::get('charge-invoice/{id}', 'Charge\ChargeController@showThroughInvoice'); //Correct//
	// Return all payments in a invoice
	Route::get('payment-invoice/{id}', 'Payment\PaymentController@showThroughInvoice');
	// Get all the countries
	Route::get('countries', 'Geolocation\GeolocationController@countries'); //Correct//
	// Get all the states
	Route::get('states', 'Geolocation\GeolocationController@states'); //Correct//
	// Get all cities
	Route::get('cities', 'Geolocation\GeolocationController@cities'); //Correct//
	// Get all payments in a community
	Route::get('payment-residence/{id}', 'Residence\ResidenceController@getPaymentThroughResidence');//Correct//
	// Get the defaulters of a community
	Route::get('defaulters/{id}', 'Property\PropertyController@getDefaulters');//correct//recently
	// Get the properties who has paid, but hasn't confirmed the payments.
	Route::get('unconfirmed-payments/{id}', 'Payment\PaymentController@getPropertiesPayed');//Correct//Reformular esta ruta completamente.
	// Get the unpaid invoices from a property
	Route::get('inactive-payments-property/{id}', 'Property\PropertyController@getInactivePaymentsFromProperty');
	// Get types of residences from residences_type
	Route::get('residences-types/', 'Residence\ResidenceController@getResidenceType');//Correct
	// Get all banks in the DB
	Route::get('banks/', 'Payment\PaymentController@getBanks'); //Correct//
	// Get all methods in the DB
	Route::get('methods/', 'Payment\PaymentController@getMethodsPayments'); //Correct//
	// Get the types of charges
	Route::get('charges-types/', 'Charge\ChargeController@getChargesTypes'); //Correct//
	// Get all the currencies
	Route::get('currencies/', 'Invoice\InvoiceController@Currencies'); //Correct//
	// Get status of pay.
	Route::get('status-payment/{id}/{paymentStatus}', 'Invoice\InvoiceController@paymentStatus');//Correct//
	// Pay all the invoices
	Route::get('dollar', 'Payment\PaymentController@getDollar');//Correct//
	// Turn off a invoice
	Route::get('turnOffInvoice/{id}', 'Invoice\InvoiceController@turnOffInvoice');//Correct//
	// Confirm payment
	Route::get('confirmPayment/{id}', 'Payment\PaymentController@confirmPayment');//Correct//
	// Gets the balance of a residence and their data.
	Route::get('balance/{id}', 'Residence\ResidenceController@balanceGeneral');//Correct//
	// Return the last invoice of a residence
	Route::get('checkIfPayed/{invoice_id}/{property_id}', 'Invoice\InvoiceController@checkIfPayed');//Correct//
    // Get dollar price
    Route::get('bcv-price', 'Charge\ChargeController@dolarPrice');//Correct//
    // Create payment confirmed
    Route::post('payment-confirmed', 'Payment\PaymentController@createAndConfirm');
    Route::apiResource('prontopago', 'ProntoPagoController');
});