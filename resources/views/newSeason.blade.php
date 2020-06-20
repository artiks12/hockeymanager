@extends('layouts.copy')
<?php 
    $user = Auth::user()->toArray();
    $id = $user['id'];
?>
@if($statuss == 1)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="leagueName">{{__('messages.new_season')}}</div>
            </div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'LeagueController@seasonCreate', 'id' => $id])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('name', __('messages.name').':') }}</td>
                            <td>{{ Form::text(('name'), '', ['class' => 'form-control'.
                            ($errors-> has('name') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('name'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{ Form::label('ch[]', $team->teamName) }}</td>
                                <td>{{ Form::checkbox(('ch[]'), $team->id) }}</td>
                            </tr>
                        @endforeach
                    </table>
                {{ Form::submit(__('messages.create')) }}
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
                <div class="leagueName">{{__('messages.add_teams')}}</div>
            </div>
            <div class="card-body">
                {{__('messages.there_are_no_teams_to_add')}}
            </div>
        </div>
    </div>
</div>
@endsection
@endif


