@extends('layouts.copy')
<style>
    div.games
    {
        display:none;
    }
</style>
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="leagueName" style="display:inline;">{{$info->leagueName}}</div>
            </div>
            <div class="card-body">
                <div class="makeSeason"><a href="{{ action('LeagueController@new',$id) }}">Make a New Season</a></div>
                <div class="addTeam"><a href="{{ action('LeagueController@add',$id) }}">Add Teams To League</a></div>
                <div class="addGame"><a href="{{ action('GameController@create',$id) }}">Add Games To season</a></div>
                <div class="addPlayer"><a href="{{ action('PlayerController@create',$id) }}">Add Player To League</a></div>
            </div>
        </div>
    </div>
</div>
@endsection
