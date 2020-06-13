<?php

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

Route::get('/', function () {
    return view('home');
});

Route::get('leagues', 'LeagueController@index');
Route::get('league={id}', 'LeagueController@menu');
Route::post('import', 'LeagueController@import');
Route::post('season', 'LeagueController@seasonCreate');
Route::get('league={id}/addTeams', 'LeagueController@add');
Route::get('league={id}/newSeason', 'LeagueController@new');
Route::get('league={id}/newGames', 'GameController@create');
Route::post('newGames/store', 'GameController@store');
Route::post('leagues', 'LeagueController@store');
Route::get('leagues={id}', 'LeagueController@show');

Route::get('league={id}/options', 'SeasonController@options');

Route::get('/leagues={leagueId}/season={seasonId}', 'LeagueController@season');

Route::get('teams', 'TeamController@index');
Route::get('team={id}/page={page?}', 'TeamController@menu');
Route::post('teams', 'TeamController@store');
Route::get('teams={id}', 'TeamController@show');


Route::get('players', 'PlayerController@index');

Route::get('games', 'GameController@index');
Route::get('games/search', 'GameController@search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
