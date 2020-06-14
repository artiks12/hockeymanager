@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Filter</div>

            <div class="card-body">
                {{ Form::open([ 'method' => 'get', 'action' => 'GameController@search'])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('date', 'From:') }}</td>
                            <td>{{ Form::date('date', '', ['class' => 'form-control'.
                            ($errors-> has('date') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('date'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('League', 'League:') }}</td>
                            <td>{{ Form::select('League', $leagues, old('League'),['class' => 'form-control'.
                            ($errors-> has('League') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('League'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('League') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Type', 'Game Type:') }}</td>
                            <td>{{ Form::select('Type', array('0' => 'all','1' => 'regular game', '2' => 'play-off game'), old('Type'),['class' => 'form-control'.
                            ($errors-> has('Type') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Type'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Type') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Team', 'Team:') }}</td>
                            <td>{{ Form::select('Team', $teams, old('Team'),['class' => 'form-control'.
                            ($errors-> has('Team') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('HomeTeam'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('HomeTeam') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                    </table>
                {{ Form::submit('Add') }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">List</div>

            <div class="card-body">
                <table>
                    @foreach($games as $game)
                    <?php
                        $season = App\Season::where('id','=',$game->season)->first();
                        $league = App\League::where('id','=',$season->league)->first();
                        $host = App\Team::where('id','=',$game->HostTeam)->first();
                        $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                    ?>
                    @if(date('Y-m-d', strtotime($game->date))==date('Y-m-d', strtotime($date)))
                    <tr onclick="location.href='{{url('games='.$game->id.'/log')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px; width:100px;'>@if($game->type==1) Regular Season @else Play-off @endif</td>
                        <td style='border:solid; border-width:1px; width:600px;'>{{$league->leagueName}} {{$season->seasonName}} - {{$game->date}} - {{$host->teamName}} vs {{$visit->teamName}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL){{$game->HomeScore}} : {{$game->VisitorScore}} @endif</td>
                    </tr>
                    @endif
                    @endforeach
                </table> 
            </div>
        </div>
    </div>
</div>
@endsection
