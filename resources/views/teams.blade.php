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
                            <td>{{ Form::label('from', 'From:') }}</td>
                            <td>{{ Form::date('from', '', ['class' => 'form-control'.
                            ($errors-> has('from') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('from'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('from') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('to', 'To:') }}</td>
                            <td>{{ Form::date('to', '', ['class' => 'form-control'.
                            ($errors-> has('to') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('to'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('to') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Type', 'Game Type:') }}</td>
                            <td>{{ Form::select('Type', array('0' => 'all','1' => 'regular game', '2' => 'play-off game'), '',['class' => 'form-control'.
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
                            <td>{{ Form::select('Team', $teams, '',['class' => 'form-control'.
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
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                <?php
                    $leagues = App\League::all();
                ?>
                <h4>Teams with no league</h4>
                <ul>
                @foreach($teams as $team)
                    @if($team->league==NULL)
                    <li><a href='{{action('TeamController@show',$team->id)}}'>{{$team->teamName}}</a></li>
                    @endif
                @endforeach
                </ul>
                <br>
                @foreach($leagues as $league)
                    <h4>{{$league->leagueName}}</h4>
                    <ul>
                    @foreach($teams as $team)
                    @if($team->league==$league->id)
                    <li><a href='{{action('TeamController@show',$team->id)}}'>{{$team->teamName}}</a></li><br>
                    @endif
                    @endforeach
                    </ul>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection