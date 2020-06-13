@extends('layouts.copy')

@section('content')
<?php 
    $user = Auth::user()->toArray();
    $statemet = $user['id']==$league['id'];
    $leagueId=$league->id;
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
                    There are no seasons for this league.
                @endif
            </div>
        </div>
    </div>
</div>
@endsection