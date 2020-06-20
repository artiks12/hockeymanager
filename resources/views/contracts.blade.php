@extends('layouts.copy')
<style>
    div.games
    {
        display:none;
    }
</style>
<?php 
    $user = Auth::user();
    $team = App\Team::where('manager','=',$user->id)->first();
?>
@if($team->id == $player->team || $player->team==NULL)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h4>{{__('messages.sign_a_player')}}</h4></div>
            <div class="card-body">
                <h5>{{$player->name}} {{$player->surname}}</h5>
                <h6>{{__('messages.birthday')}} {{$player->birthday}}</h6>
                <h6>{{__('messages.height')}} {{$player->height}}</h6>
                <h6>{{__('messages.weight')}} {{$player->weight}}</h6>
                {{ Form::open([ 'method' => 'post', 'url' => 'player='.$player->id.'/team='.$team->id.'/signed'])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('number', __('messages.number').':') }}</td>
                            <td>{{ Form::text(('number'), $player->number, ['class' => 'form-control'.
                            ($errors-> has('number') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('number'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('number') }}</strong>
                            </span>
                        @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('money', __('messages.total_salary').':') }}</td>
                            <td>{{ Form::text(('money'), '', ['class' => 'form-control'.
                            ($errors-> has('money') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('money'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('money') }}</strong>
                            </span>
                        @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('years', __('messages.years').':') }}</td>
                            <td>{{ Form::text(('years'), '', ['class' => 'form-control'.
                            ($errors-> has('years') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('years'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('years') }}</strong>
                            </span>
                        @endif
                            </td>
                        </tr>
                    </table>
                {{ Form::submit(__('messages.sign')) }}
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
            <div class="card-header"><h4>{{__('messages.sign_a_player')}}</h4></div>
            <div class="card-body">
                {{__('messages.this_player_already_has_a_team')}}
            </div>
        </div>
    </div>
</div>
@endsection
@endif