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
                <div class="leagueName">Add Teams</div>
            </div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'LeagueController@seasonCreate', 'id' => $id])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('name', 'Name:') }}</td>
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
                <div class="leagueName">Add Teams</div>
            </div>
            <div class="card-body">
                There are no teams to add.
            </div>
        </div>
    </div>
</div>
@endsection
@endif


