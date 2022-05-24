<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DailyBdController;
use App\Http\Controllers\WeeklyBdController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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
    return view('auth.login');
});


Auth::routes();


/* Users Authentication */
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'userGraph'])->name('home.graph');

    //Routes for Next Week Tasks.
    Route::get('/todos', [App\Http\Controllers\NewTodoController::class, 'index'])->name('todos.index');
    Route::get('/todos/create',  [App\Http\Controllers\NewTodoController::class, 'create'])->name('todos.create');
    Route::post('/todos',  [App\Http\Controllers\NewTodoController::class, 'store'])->name('todos.store');
    Route::delete('/todos/delete/{id}', [App\Http\Controllers\NewTodoController::class, 'destroy'])->name('todos.destroy');
    Route::delete('/selected-todos', [App\Http\Controllers\NewTodoController::class, 'deleteCheckedTodos'])->name('todos.deleteSelected');
    Route::get('/todos/edit/{id}', [App\Http\Controllers\NewTodoController::class, 'edit'])->name('todos.edit');
    Route::put('/todos/update/{id}', [App\Http\Controllers\NewTodoController::class, 'update'])->name('todos.update');
    Route::get('/todos/showcompleted/', [App\Http\Controllers\NewTodoController::class, 'showcompleted'])->name('todos.showcompleted');
    Route::get('/todos/showdeleted/', [App\Http\Controllers\NewTodoController::class, 'showdeleted'])->name('todos.showDeleted');

    //Routes for Weekly Tasks.
    Route::get('/tasks', [App\Http\Controllers\NewTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/taskForm', [App\Http\Controllers\NewTaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [App\Http\Controllers\NewTaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/update/{id}', [App\Http\Controllers\NewTaskController::class, 'update'])->name('tasks.update');
    Route::get('/tasks/edit/{id}', [App\Http\Controllers\NewTaskController::class, 'edit'])->name('tasks.edit');
    Route::delete('/tasks/delete/{id}', [App\Http\Controllers\NewTaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/showCompleted/', [App\Http\Controllers\NewTaskController::class, 'showcompleted'])->name('tasks.showcompleted');
    Route::get('/tasks/showDeleted/', [App\Http\Controllers\NewTaskController::class, 'showDeleted'])->name('tasks.showDeleted');
    Route::get('/tasks/search/', [App\Http\Controllers\NewTaskController::class, 'search'])->name('tasks.search');
});

/* Admin Authentication */
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.Home');

    //Route for user management.
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/userForm', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::delete('/admin/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    //Route for role management
    Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('/admin/rolesForm', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
    Route::post('/admin/roles' , [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');


    //Route for Weekly Task
    Route::get('/admin/tasks', [App\Http\Controllers\AdminTasksController::class, 'index'])->name('Admintasks.index');
    Route::get('/admin/tasks/search/', [App\Http\Controllers\AdminTasksController::class, 'search'])->name('Admintasks.search');
    Route::get('/admin/tasks/create/',  [App\Http\Controllers\AdminTasksController::class, 'create'])->name('Admintasks.create');
    Route::post('/admin/tasks',  [App\Http\Controllers\AdminTasksController::class, 'store'])->name('Admintasks.store');
    Route::put('/admin/tasks/update/{id}', [App\Http\Controllers\AdminTasksController::class, 'update'])->name('Admintasks.update');
    Route::get('/admin/tasks/edit/{id}', [App\Http\Controllers\AdminTasksController::class, 'edit'])->name('Admintasks.edit');
    Route::delete('/admin/tasks/delete/{id}', [App\Http\Controllers\AdminTasksController::class, 'destroy'])->name('Admintasks.destroy');

    //Route for Next Week Task
    Route::get('/admin/todos', [App\Http\Controllers\AdminTodosController::class, 'index'])->name('Admintodos.index');
    Route::get('/admin/todos/search/', [App\Http\Controllers\AdminTodosController::class, 'search'])->name('Admintodos.search');
    Route::get('/admin/todos/create/',  [App\Http\Controllers\AdminTodosController::class, 'create'])->name('Admintodos.create');
    Route::post('/admin/todos',  [App\Http\Controllers\AdminTodosController::class, 'store'])->name('Admintodos.store');
    Route::put('/admin/todos/update/{id}', [App\Http\Controllers\AdminTodosController::class, 'update'])->name('Admintodos.update');
    Route::get('/admin/todos/edit/{id}', [App\Http\Controllers\AdminTodosController::class, 'edit'])->name('Admintodos.edit');
    Route::delete('/admin/todos/delete/{id}', [App\Http\Controllers\AdminTodosController::class, 'destroy'])->name('Admintodos.destroy');
    

});

//Routes for To Do List.
/*Route::group(['middleware' => 'auth'], function() {
    Route::get('/todos', [App\Http\Controllers\NewTodoController::class, 'index'])->name('todos.index');
    Route::get('/todos/create',  [App\Http\Controllers\NewTodoController::class, 'create'])->name('todos.create');
    Route::post('/todos',  [App\Http\Controllers\NewTodoController::class, 'store'])->name('todos.store');
    Route::delete('/todos/delete/{id}', [App\Http\Controllers\NewTodoController::class, 'destroy'])->name('todos.destroy');
    Route::delete('/selected-todos', [App\Http\Controllers\NewTodoController::class, 'deleteCheckedTodos'])->name('todos.deleteSelected');
    Route::get('/todos/edit/{id}', [App\Http\Controllers\NewTodoController::class, 'edit'])->name('todos.edit');
    Route::put('/todos/update/{id}', [App\Http\Controllers\NewTodoController::class, 'update'])->name('todos.update');
    Route::get('/todos/showcompleted/', [App\Http\Controllers\NewTodoController::class, 'showcompleted'])->name('todos.showcompleted');
    Route::get('/todos/showdeleted/', [App\Http\Controllers\NewTodoController::class, 'showdeleted'])->name('todos.showDeleted');

});*/


//roles 

/*Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
Route::get('/admin/rolesForm', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
Route::post('/admin/roles' , [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');

  //user management
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/userForm', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
*/

/*Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/userForm', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::delete('/admin/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    //Route for role management
    Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('/admin/rolesForm', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
    Route::post('/admin/roles' , [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
});*/

/*Routes For project
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/projectForm', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
Route::put('/projects/{projects}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
Route::put('/projects/{projects}', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{projects}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');
Route::get('/projects/{projects}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit');
*/



//Routes For dailyBd CRUD
Route::get('dailyBds', [DailyBdController::class, 'index']);
Route::get('dailyBds', [DailyBdController::class, 'show']);

//Routes For DailyBd CRUD
Route::get('weeklyBds', [WeeklyBdController::class, 'index']);
Route::get('weeklyBds', [WeeklyBdController::class, 'show']);