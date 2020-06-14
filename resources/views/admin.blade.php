@extends('layouts.copy')
<style>
    div.games
    {
        display:none;
    }
</style>
<?php 
    $user = Auth::user();
?>
@if($user->role==4)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            @if($page=='menu')
            <div class="card-header">Admin Menu</div>
            <div class="card-body">
                <div class="makePlayer"><a href="{{ url('admin/makePlayer') }}">Make a Player</a></div>
                <div class="RemoveUser"><a href="{{ url('admin/userRemove') }}">Remove a User</a></div>
                <div class="GiveLeague"><a href="{{ url('admin/leagueGive') }}">Give a League</a></div>
                <div class="GiveTeam"><a href="{{ url('admin/teamGive') }}">Give a Team</a></div>
            </div>
            @endif
            @if($page=='makePlayer')
            <div class="card-header">Create Player</div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'PlayerController@store'])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('Name', 'Name:') }}</td>
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
                            <td>{{ Form::label('Surname', 'Surname:') }}</td>
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
                            <td>{{ Form::label('date', 'Birthday:') }}</td>
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
                            <td>{{ Form::label('height', 'Height:') }}</td>
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
                            <td>{{ Form::label('weight', 'Weight:') }}</td>
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
                            <td>{{ Form::label('Position', 'Position:') }}</td>
                            <td>{{ Form::select('Position', array('G' => 'Goalie', 'D' => 'Defenceman', 'F' => 'Forward'), old('Position'),['class' => 'form-control'.
                            ($errors-> has('Position') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Position'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Position') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                    </table>
                {{ Form::submit('Add') }}
                {{ Form::close() }}
            </div>
            @endif
            @if($page=='userRemove')
            <div class="card-header">Remove a User</div>
            <div class="card-body">
                <?php 
                    $user = App\User::all()->pluck('name','id');
                ?>
                <p>
                <h4>Remove A user</h4>
                    @if(count($user)>0)
                    <table>
                    {{ Form::open([ 'method' => 'delete' , 'action' => ['AdminController@user']])}}
                    <tr>
                        <td>{{ Form::label('user', 'User:') }}</td>
                        <td>{{ Form::select('user', $user, ['class' => 'form-control'.
                        ($errors-> has('user') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('user'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('user') }}</strong>
                            </span>
                        @endif
                        </td>
                    </tr>
                    </table>
                    <div style='width:100px;'>
                    {{ Form::submit('Remove') }}
                    {{ Form::close() }}
                    </div>
                    @endif
                </p>
            </div>
            @endif
            @if($page=='leagueGive')
            <div class="card-header">Give a League</div>
            <div class="card-body">
            </div>
            @endif
            @if($page=='teamGive')
            <div class="card-header">Give a Team</div>
            <div class="card-body">
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@else
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Warning</div>
            <div class="card-body">
                You cannot access this page.
            </div>
        </div>
    </div>
</div>
@endsection
@endif