@extends('layouts.copy')

@section('content')
<?php
$leagueId=0;
foreach($seasons as $season)
{
    $league=App\League::where('id','=',$season->league)->first();
    $leagueId=$league->id;
    break;
}
    
?>

<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{$league->leagueName}}</div>
            <div class="card-body">
                @if(count($seasons)>0)
                @foreach($seasons as $season)
                <a href='{{ url('/leagues='.$leagueId.'/season='.$season->id) }}'>{{$season->seasonName}}</a>
                @endforeach
                @else
                    {{__('messages.there_are_no_seasons_for_this_league')}}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection