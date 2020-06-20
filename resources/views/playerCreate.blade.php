@extends('layouts.copy')
<?php 
    $user = Auth::user();
    $id = $user['id'];
?>
<style>
    div.games
    {
        display:none;
    }
</style>
@if($statuss==1)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="leagueName">{{__('messages.create_player')}}</div>
            </div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'PlayerController@store'])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('Name', __('messages.name').':') }}</td>
                            <td>{{ Form::text('Name', '',['class' => 'form-control'.
                            ($errors-> has('Name') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Name'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Name') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Surname', __('messages.surname').':') }}</td>
                            <td>{{ Form::text('Surname', '',['class' => 'form-control'.
                            ($errors-> has('Surname') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Surname'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Surname') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('date', __('messages.birthday').':') }}</td>
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
                            <td>{{ Form::label('height', __('messages.height').':') }}</td>
                            <td>{{ Form::number('height', '',['class' => 'form-control'.
                            ($errors-> has('height') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('height'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('height') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('weight', __('messages.weight').':') }}</td>
                            <td>{{ Form::number('weight', '',['class' => 'form-control'.
                            ($errors-> has('weight') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('weight'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Position', __('messages.position').':') }}</td>
                            <td>{{ Form::select('Position', array('G' => __('messages.goalie'), 'D' => __('messages.defenceman'), 'F' => __('messages.forward')), old('Position'),['class' => 'form-control'.
                            ($errors-> has('Position') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Position'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Position') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('Team', __('messages.team').':') }}</td>
                            <td>{{ Form::select('Team', $teams, '',['class' => 'form-control'.
                            ($errors-> has('Team') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Team'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Team') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                    </table>
                {{ Form::submit(__('messages.add')) }}
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
                <div class="leagueName">{{__('messages.create_player')}}</div>
            </div>
            <div class="card-body">
                {{__('messages.there_are_no_teams_in_the_league_to_add_players_to')}}
            </div>
        </div>
    </div>
</div>
@endsection
@endif
