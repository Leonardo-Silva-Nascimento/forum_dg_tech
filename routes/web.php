<?php

use App\Http\Controllers\Forum;
use App\Http\Controllers\Login;
use App\Http\Controllers\ProtectedDownloads;
use App\Http\Controllers\Userlist;
use Illuminate\Support\Facades\Route;

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

Route::get('Profile', [Userlist::class, 'editProfile'])
    ->name('form.update.profile');
Route::post('Profile', [Userlist::class, 'updateProfile'])
    ->name('update.userProfile');


//Rotas que listam os comentarios
Route::get('/index', function () {return redirect()->route('list.Forum');})->name('home');
Route::get('/', function () {return redirect()->route('list.Forum');});
Route::get('Forum', [Forum::class, 'index'])->name('list.Forum');

Route::post('/logout', [Login::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/nova-senha', [Login::class, 'replaceTempPasswordView'])->name('temp.password');
    Route::post('/nova-senha', [Login::class, 'replaceTempPassword'])->name('send.temp.password');
});

Route::get('get-files/{filename?}', [ProtectedDownloads::class, 'showJobImage'])
    ->name('get.files');

Route::get('/usuarios', [Userlist::class, 'index'])->name('list.users');
Route::post('/usuarios', [Userlist::class, 'index'])->name('listP.users');

Route::get('usuarios/criar', [Userlist::class, 'create'])
    ->name('form.store.user');

Route::post('usuarios/criar', [Userlist::class, 'store'])
    ->name('store.user');

Route::get('/login', [Login::class, 'index'])->name('login');
Route::post('/login', [Login::class, 'login'])->name('action.login');
Route::get('/esqueci-minha-senha', [Login::class, 'forgotPassword'])->name('forgot.password');
Route::post('/esqueci-minha-senha', [Login::class, 'recoveryPasswordSend'])->name('forgot.password.send');
Route::get('/recuperar-minha-senha', [Login::class, 'recoveryPassword'])->name('recovery.password');
Route::get('/recuperar-minha-senha/{code}', [Login::class, 'recoveryPassword'])->name('recovery.password');
Route::post('/recuperar-minha-senha/{code}', [Login::class, 'recoveryPasswordSend'])->name('recovery.password.send');


Route::post('api/comentarios', [Forum::class, 'store']);
Route::post('api/respostas', [Forum::class, 'storeReply']);