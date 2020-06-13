@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4>Leagues</h4></div>
            
            <div class="card-body">
                @foreach($leagues as $league)
                <a href='{{action('LeagueController@show',$league->id)}}'>{{$league->leagueName}}</a><br>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection