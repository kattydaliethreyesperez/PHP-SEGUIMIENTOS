<?php

// Importar las clases y controladores necesarios
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TipCalculatorController;
use App\Http\Controllers\keyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\MemoryGameController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\StopwatchController;

// RUTAS EJERCICIO 1: TAREAS
Route::get('/', [InicioController::class, 'index']);
Route::get('/tareas', [TasksController::class, 'index'])->name('tasks.index');
Route::post('/tareas', [TasksController::class, 'store'])->name('tasks.store');
Route::put('/tareas/{task}/completar', [TasksController::class, 'toggle'])->name('tasks.toggle');
Route::delete('/tareas/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');

// RUTAS EJERCICIO 2: CALCULADORA DE PROPINAS
Route::get('/propinas', [TipCalculatorController::class, 'index'])->name('tips.index');

// RUTAS EJERCICIO 3: GENERADOR DE CLAVES
Route::get('/key', [keyController::class, 'index'])->name('key.index');
Route::post('/key/generar', [keyController::class, 'generar'])->name('key.generar');

// RUTAS EJERCICIO 4: GESTOR DE GASTOS
Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

// RUTAS EJERCICIO 5: SISTEMA DE RESERVAS
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::put('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

// RUTAS EJERCICIO 6: GESTOR DE NOTAS
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

// RUTAS EJERCICIO 7: CALENDARIO DE EVENTOS
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

// RUTAS EJERCICIO 8: PLATAFORMA DE RECETAS
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

// RUTAS EJERCICIO 9: JUEGO DE MEMORIA
Route::get('/memory', [MemoryGameController::class, 'index'])->name('memory.index');

// RUTAS EJERCICIO 10: PLATAFORMA DE ENCUESTAS
Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
Route::post('/surveys/{survey}/vote', [SurveyController::class, 'vote'])->name('surveys.vote');
Route::delete('/surveys/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');

// RUTAS EJERCICIO 11: CRONOMETRO ONLINE
Route::get('/stopwatch', [StopwatchController::class, 'index'])->name('stopwatch.index');
