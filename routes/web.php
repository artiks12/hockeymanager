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
Route::get('league', 'LeagueController@begin');
Route::get('team', 'TeamController@begin');
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
Route::get('league={id}/addPlayer', 'PlayerController@create');
Route::post('newPlayer', 'PlayerController@store');

Route::get('/leagues={leagueId}/season={seasonId}', 'LeagueController@season');

Route::get('teams', 'TeamController@index');
Route::get('teams/search', 'TeamController@search');
Route::get('team={id}/page={page}', 'TeamController@menu');
Route::post('team={id}/statistician', 'TeamController@statistician');
Route::get('team={id}/sign={player}', 'PlayerController@sign');
Route::get('player={id}/release', 'PlayerController@release');
Route::post('player={id}/team={team}/signed', 'PlayerController@get');
Route::post('teams', 'TeamController@store');
Route::get('teams={id}/page={page}', 'TeamController@show');


Route::get('players', 'PlayerController@index');
Route::get('players/search', 'PlayerController@search');
Route::get('players={id}', 'PlayerController@show');
Route::get('players={id}/season={season}', 'PlayerController@byGame');

Route::get('games', 'GameController@index');
Route::get('games={id}/{page}', 'GameController@show');
Route::get('games/search', 'GameController@search');
Route::post('game={game}/team={team}/rosterupdate', 'GameController@roster');
Route::post('game={game}/team={team}/addGoal', 'GameController@addGoal');
Route::post('game={game}/team={team}/addPenalty', 'GameController@addPenalty');
Route::get('game={game}/finish', 'GameController@finish');
Route::post('game={game}/team={team}/goalie={player}', 'GameController@updateGoalie');
Route::post('game={game}/team={team}/field={player}', 'GameController@updateField');

Route::get('admin/{page}','AdminController@index');
Route::delete('admin/removeUser','AdminController@user');
Route::post('admin/giveLeague','AdminController@leagueGive');
Route::post('admin/giveTeam','AdminController@teamGive');
Route::post('admin/makeLeague','AdminController@leagueMake');
Route::post('admin/makeTeam','AdminController@teamMake');

Route::get('lang/{locale}','LanguageController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
