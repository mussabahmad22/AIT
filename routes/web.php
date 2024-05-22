<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\User;

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

    $users = User::where('remember_token', NULL)->count();
    $completed =  User::where('remember_token', NULL)->where('completed_status', 1)->where('active_status', 2)->where('suspended_status', 0)->count();
    $in =  User::where('remember_token', NULL)->where('active_status', 1)->where('suspended_status', 0)->count();
    $sus =  User::where('suspended_status', 1)->count();

    return view('dashboard', compact('users', 'completed','in','sus'));
    
})->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/admin_logout', [AdminController::class, 'logout'])->name('admin_logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    //===============================Manage Staff Members====================================
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/add_users_show', [AdminController::class, 'add_users_show'])->name('add_users_show');
    Route::post('/add_users' , [AdminController::class, 'add_users'])->name('add_users');
    Route::get('/edit_user/{id}' , [AdminController::class, 'edit_user'])->name('edit_user');
    Route::post('/update_user/{id}' , [AdminController::class, 'update_user'])->name('update_user');
    Route::delete('/delete_user' , [AdminController::class, 'delete_user'])->name('delete_user');
//==================================Add tracks user ============================================
    Route::get('/upload_tasks_show/{id}', [AdminController::class, 'upload_tasks_show'])->name('upload_tasks_show');
    Route::post('/task_data', [AdminController::class, 'task_data'])->name('task_data');
    Route::get('/edit_tasks_show/{id}', [AdminController::class, 'edit_tasks_show'])->name('edit_tasks_show');
    Route::post('/update_task_data', [AdminController::class, 'update_task_data'])->name('update_task_data');


    Route::delete('/edit_tasks_show/delete_song/' , [AdminController::class, 'delete_song'])->name('delete_song');

    Route::delete('/multiple_delete_tracks' , [AdminController::class, 'multiple_delete_tracks'])->name('multiple_delete_tracks');


    // Route::delete('/edit_tasks_show/delete_song/{id}' , [AdminController::class, 'delete_song'])->name('delete_song');

    Route::get('/user_details/{id}', [AdminController::class, 'user_details'])->name('user_details');
    Route::get('/breakdown/{id}', [AdminController::class, 'breakdown'])->name('breakdown');
    Route::get('/in_active_users', [AdminController::class, 'in_active_users'])->name('in_active_users');
    Route::get('/completed_tasks', [AdminController::class, 'completed_tasks'])->name('completed_tasks');
    Route::get('/suspended_users', [AdminController::class, 'suspended_users'])->name('suspended_users');
    
    
    Route::post('/change_suspended_status', [AdminController::class, 'change_suspended_status'])->name('change_suspended_status');
    Route::get('/change_un_suspended_status/{id}', [AdminController::class, 'change_un_suspended_status'])->name('change_un_suspended_status');

    Route::get('/user_details/{id}/cd_data/{val}', [AdminController::class, 'cd_data']
    )->name('cd_data');
    Route::get('/user_details_view/{id}/cd_data/{val}', [AdminController::class, 'user_details_view']
    )->name('user_details_view');
    Route::get('https://wh717090.ispot.cc/auditory-integration/user_details/{id}/cd_data/{val}', [AdminController::class, 'cd_data']
    )->name('cd_data');

    Route::get('/user_details_breakdown/{id}/cd_data/{val}', [AdminController::class, 'cd_data_breakdown']
    )->name('cd_data_breakdown');

    Route::get('/cd_data_breakdown_view/{id}/cd_data/{val}', [AdminController::class, 'cd_data_breakdown_view']
    )->name('cd_data_breakdown_view');
    Route::get('https://wh717090.ispot.cc/auditory-integration/user_details_breakdown/{id}/cd_data/{val}', [AdminController::class, 'cd_data_breakdown']
    )->name('cd_data_breakdown');

    Route::post('/tmp-upload', [AdminController::class, 'tmpUpload'])->name('tmpUpload');
    Route::delete('/tmp-delete' , [AdminController::class, 'tmpDelete'])->name('tmpDelete');

    Route::get('/users_by_status/{id}', [AdminController::class, 'users_by_status'])->name('users_by_status');
    Route::get('https://wh717090.ispot.cc/auditory-integration/users_by_status/{id}', [AdminController::class, 'users_by_status']
    )->name('users_by_status');

    Route::get('/contact_form_show', [AdminController::class, 'contact_form_show'])->name('contact_form_show');
    Route::post('/contact_data', [AdminController::class, 'contact_data'])->name('contact_data');

    
    Route::get('/change_status_operator/{id}/{val}', [AdminController::class, 'change_status_operator']
    )->name('change_status_operator');

    Route::get('https://wh717090.ispot.cc/auditory-integration/change_status_operator/{id}/{val}', [AdminController::class, 'change_status_operator']
    )->name('change_status_operator');


    Route::post('/change_resolved_status', [AdminController::class, 'change_resolved_status']
    )->name('change_resolved_status');

    Route::post('https://wh717090.ispot.cc/auditory-integration/change_resolved_status', [AdminController::class, 'change_resolved_status']
    )->name('change_resolved_status');

    Route::get('/search_breakdown', [AdminController::class, 'search_breakdown'])->name('search_breakdown');


    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

    Route::post('/profile_data', [AdminController::class, 'profile_data'])->name('profile_data');




    

});

Route::get('/dashboard', function () {

     $users = User::where('remember_token', NULL)->count();
    $completed =  User::where('remember_token', NULL)->where('completed_status', 1)->where('active_status', 2)->where('suspended_status', 0)->count();
    $in =  User::where('remember_token', NULL)->where('active_status', 1)->where('suspended_status', 0)->count();
    $sus =  User::where('suspended_status', 1)->count();

    return view('dashboard', compact('users', 'completed','in','sus'));
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
