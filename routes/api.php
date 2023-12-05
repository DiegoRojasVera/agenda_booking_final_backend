<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\ServiciosStylistController;
use App\Http\Controllers\StylistController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Bookin Router
Route::get('services', 'App\Http\Controllers\ServicesController@index');
Route::post('services', 'App\Http\Controllers\ServicesController@store');
Route::get('services/{id}', 'App\Http\Controllers\ServicesController@show');

Route::get('grafico', 'App\Http\Controllers\AppointmentController@index');
Route::get('monthly-summary/{month?}', 'App\Http\Controllers\AppointmentController@monthlySummary');
Route::get('controlmesservice/{month}/{service?}', 'App\Http\Controllers\AppointmentController@controlmesservice');
Route::get('controlmesstylist/{month}/{stylist?}', 'App\Http\Controllers\AppointmentController@controlmesstylist');
Route::get('controlmesstulistlist/{month}', 'App\Http\Controllers\AppointmentController@controlmesstulistlist');
Route::get('controlmesservicelist/{month?}','App\Http\Controllers\AppointmentController@controlmesservicelist');
Route::get('cantidadmeslist','App\Http\Controllers\AppointmentController@cantidadmeslist');


Route::post('/puntuacion', 'App\Http\Controllers\PuntuacionController@store'); // Guardar una nueva puntuación
Route::get('/puntuacion/promedio/{stylist}', 'App\Http\Controllers\PuntuacionController@promedioPorStylist'); // Obtener el promedio de puntuaciones para un stylist en particular
Route::get('/puntuacion', 'App\Http\Controllers\PuntuacionController@index'); // Listar todas las puntuaciones
Route::get('/puntuacion/stylist/{stylist}', 'App\Http\Controllers\PuntuacionController@listarPorStylist'); // Listar todas las puntuaciones para un stylist en particular
Route::get('/clientes/{email}/stylists-services', 'App\Http\Controllers\PuntuacionController@showStylistsAndServices');
Route::get('/services/{id}/name',  'App\Http\Controllers\PuntuacionController@getServiceName');


Route::get('appointment/{id}', 'App\Http\Controllers\ServicesController@showAppointment');
Route::get('appointment', 'App\Http\Controllers\ServicesController@showAppointment');
Route::delete('appointment/{id}', 'App\Http\Controllers\ServicesController@destroy');


Route::get('Prueba', 'App\Http\Controllers\ClientController@Prueba');
Route::get('reservascliente/{email}', 'App\Http\Controllers\ClientController@show');
Route::get('listar', 'App\Http\Controllers\ClientController@index');
Route::get('postsnologin', 'App\Http\Controllers\PostController@indexnologin');

Route::get('/updatesversion', 'App\Http\Controllers\UpdateController@index');


Route::get('clients', 'App\Http\Controllers\ClientController@index');
Route::get('clientsday', 'App\Http\Controllers\ClientController@indexToday');
Route::get('clientsStylist/{stylist}', 'App\Http\Controllers\ClientController@showStylist');
Route::get('clients/{email}', 'App\Http\Controllers\ClientController@show'); // get single client
Route::get('client/{stylist}', 'App\Http\Controllers\ClientController@showAll'); // get all client showallID
Route::get('clientid/{id}', 'App\Http\Controllers\ClientController@showallID'); // get all client showallID
Route::delete('clients/{id}', 'App\Http\Controllers\ClientController@destroy');
Route::post('export-data', 'App\Http\Controllers\ClientController@exportData');

//Stylist
Route::get('stylist/{id}', 'App\Http\Controllers\StylistController@show'); //listar uno
Route::get('stylist', 'App\Http\Controllers\StylistController@index'); //listar todo
Route::post('stylist', 'App\Http\Controllers\StylistController@register'); //crearte
Route::delete('stylist/{id}', 'App\Http\Controllers\StylistController@destroy');
Route::get('/stylistsbusbar/{id}', 'App\Http\Controllers\StylistController@searchById'); //buscar
Route::put('stylists/{id}', 'App\Http\Controllers\StylistController@update');
Route::get('stylist/sucursal/{sucursal}', 'App\Http\Controllers\StylistController@indexBySucursal'); //listar stylsit por sucursal.
Route::get('/stylists/{id}', [StylistController::class, 'getStylistById']);


//ServiceStylist
Route::get('servicestylist', 'App\Http\Controllers\ServiciosStylistController@index'); //listar todo
Route::get('servicestylist/{id}', 'App\Http\Controllers\ServiciosStylistController@show'); // get single Stylist
Route::get('servicestylistall/{stylist_id}', 'App\Http\Controllers\ServiciosStylistController@showServicesStylist'); // Listar los servicios que realiza la estilista
Route::get('service-stylists/{serviceId}/{day}', [ServiciosStylistController::class, 'getStylistsForServiceAndDay']);


Route::get('service/{id}', 'App\Http\Controllers\ServiceController@show');
Route::get('service', 'App\Http\Controllers\ServiceController@index');
Route::post('servicestylistcrearte', 'App\Http\Controllers\ServiceController@store');

Route::resource('/client', 'App\Http\Controllers\ProductsController')->except([
  'create', 'edit'
]);


Route::get('userlist', 'App\Http\Controllers\UserController@index');
Route::get('userlist/{id}', 'App\Http\Controllers\UserController@show');
Route::delete('userlist/{id}', 'App\Http\Controllers\UserController@destroy');


Route::get('userlast', 'App\Http\Controllers\AuthController@lastId');

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

  //User
  Route::get('/user', [AuthController::class, 'user']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::PUT('/user/{id}', [AuthController::class, 'update']);
  Route::PUT('/updateToken/{id}', [AuthController::class, 'updateToken']);

  // Post
  Route::get('/posts', [PostController::class, 'index']); // all posts
  Route::post('/posts', [PostController::class, 'store']); // create post
  Route::get('/posts/{id}', [PostController::class, 'show']); // get single post
  Route::put('/posts/{id}', [PostController::class, 'update']); // update post
  Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

  //clients
  //  Route::get('/clients/{id}', [ClientController::class, 'show']); // get single client
  //  Route::get('/clients', [ClientController::class, 'index']); // all clients posts

  // Comment
  Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
  Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
  Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
  Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

  // Like
  Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike']); // like or dislike back a post
});
