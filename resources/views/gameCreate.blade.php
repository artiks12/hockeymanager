@extends('layouts.copy')
<?php 
    $user = Auth::user()->toArray();
    $id = $user['id'];
?>
@if($statuss==1)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="leagueName">Add Games</div>
            </div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'GameController@store'])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('date', 'Date:') }}</td>
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
                            <td>{{ Form::label('time', 'Time:') }}</td>
                            <td>{{ Form::time('time', '', ['class' => 'form-control'.
                            ($errors-> has('time') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('time'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('time') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Type', 'Game Type:') }}</td>
                            <td>{{ Form::select('Type', array('1' => 'regular game', '2' => 'play-off game'), '',['class' => 'form-control'.
                            ($errors-> has('Type') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Type'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Type') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('HomeTeam', 'Home Team:') }}</td>
                            <td>{{ Form::select('HomeTeam', $teams, '',['class' => 'form-control'.
                            ($errors-> has('HomeTeam') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('HomeTeam'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('HomeTeam') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('VisitingTeam', 'Visiting Team:') }}</td>
                            <td>{{ Form::select('VisitingTeam', $teams, '', ['class' => 'form-control'.
                            ($errors-> has('VisitingTeam') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('VisitingTeam'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('VisitingTeam') }}</strong>
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
</div>
@endsection
@else
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="leagueName">Add Games</div>
            </div>
            <div class="card-body">
                There is no season to add games to
            </div>
        </div>
    </div>
</div>
@endsection
@endif
