@extends('layouts.copy')
<style>
    div.games
    {
        display:none;
    }
</style>
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            @if($page=='menu')
            <div class="card-header">{{__('messages.admin_menu')}}</div>
            <div class="card-body">
                <div class="makePlayer"><a href="{{ url('admin/makePlayer') }}">{{__('messages.create_player')}}</a></div>
                <div class="RemoveUser"><a href="{{ url('admin/userRemove') }}">{{__('messages.remove_user')}}</a></div>
                <div class="GiveLeague"><a href="{{ url('admin/leagueGive') }}">{{__('messages.give_league')}}</a></div>
                <div class="GiveTeam"><a href="{{ url('admin/teamGive') }}">{{__('messages.give_team')}}</a></div>
                <div class="MakeLeague"><a href="{{ url('admin/leagueMake') }}">{{__('messages.create_league')}}</a></div>
                <div class="MakeTeam"><a href="{{ url('admin/teamMake') }}">{{__('messages.create_team')}}</a></div>
            </div>
            @endif
            @if($page=='makePlayer')
            <div class="card-header">{{__('messages.create_player')}}</div>
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
                    </table>
                {{ Form::submit(__('messages.add')) }}
                {{ Form::close() }}
            </div>
            @endif
            @if($page=='userRemove')
            <div class="card-header">{{__('messages.remove_user')}}</div>
            <div class="card-body">
                <?php 
                    $user = App\User::all()->pluck('name','id');
                ?>
                <p>
                <h4>{{__('messages.remove_user')}}</h4>
                    @if(count($user)>0)
                    <table>
                    {{ Form::open([ 'method' => 'delete' , 'action' => ['AdminController@user']])}}
                    <tr>
                        <td>{{ Form::label('user', __('messages.user').':') }}</td>
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
                    {{ Form::submit(__('messages.remove')) }}
                    {{ Form::close() }}
                    </div>
                    @else
                    {{__('messages.there_is_nothing_you_can_do')}}
                    @endif
                </p>
            </div>
            @endif
            @if($page=='leagueGive')
            <div class="card-header">{{__('messages.give_league')}}</div>
            <div class="card-body">
                <?php
                    $users = App\User::where('role','=',1)->pluck('name','id');
                    $LeaguesSelections = App\League::where('commisioner','=',NULL)->pluck('leagueName','id');
                    $leagues = App\League::all();
                    $selections = array();
                    foreach ($users as $key => $user) 
                    {
                        $exists=0;
                        foreach($leagues as $league)
                        {
                            if($key==$league->commisioner){$exists=1;}
                        }
                        if($exists==0){$selections[$key]=$user;}
                    }
                ?>
                <p>
                <h4>{{__('messages.give_league')}}</h4>
                @if(count($selections)>0 && count($LeaguesSelections)>0)
                    <table>
                    {{ Form::open([ 'method' => 'post' , 'action' => ['AdminController@leagueGive']])}}
                    <tr>
                        <td>{{ Form::label('user', __('messages.user').':') }}</td>
                        <td>{{ Form::select('user', $selections, ['class' => 'form-control'.
                        ($errors-> has('user') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('user'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('user') }}</strong>
                            </span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('league', __('messages.league').':') }}</td>
                        <td>{{ Form::select('league', $LeaguesSelections, ['class' => 'form-control'.
                        ($errors-> has('league') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('league'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('league') }}</strong>
                            </span>
                        @endif
                        </td>
                    </tr>
                    </table>
                    <div style='width:100px;'>
                    {{ Form::submit(__('messages.give')) }}
                    {{ Form::close() }}
                    </div>
                @else
                {{__('messages.there_is_nothing_you_can_do')}}
                @endif
                </p>
            </div>
            </div>
            @endif
            @if($page=='teamGive')
            <div class="card-header">{{__('messages.give_team')}}</div>
            <div class="card-body">
                <?php
                    $users = App\User::where('role','=',1)->orWhere('role','=',2)->pluck('name','id');
                    $teamsSelections = App\Team::where('manager','=',NULL)->pluck('teamName','id');
                    $teams = App\Team::all();
                    $selections = array();
                    foreach ($users as $key => $user) 
                    {
                        $exists=0;
                        foreach($teams as $team)
                        {
                            if($key==$team->manager){$exists=1;}
                        }
                        if($exists==0){$selections[$key]=$user;}
                    }
                ?>
                <p>
                <h4>{{__('messages.give_team')}}</h4>
                @if(count($selections)>0 && count($teamsSelections)>0)
                    <table>
                    {{ Form::open([ 'method' => 'post' , 'action' => ['AdminController@teamGive']])}}
                    <tr>
                        <td>{{ Form::label('user', __('messages.user').':') }}</td>
                        <td>{{ Form::select('user', $selections, ['class' => 'form-control'.
                        ($errors-> has('user') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('user'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('user') }}</strong>
                            </span>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td>{{ Form::label('team', __('messages.team').':') }}</td>
                        <td>{{ Form::select('team', $teamsSelections, ['class' => 'form-control'.
                        ($errors-> has('team') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('team'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('team') }}</strong>
                            </span>
                        @endif
                        </td>
                    </tr>
                    </table>
                    <div style='width:100px;'>
                    {{ Form::submit(__('messages.give')) }}
                    {{ Form::close() }}
                    </div>
                @else
                {{__('messages.there_is_nothing_you_can_do')}}
                @endif
                </p>
            </div>
            @endif
            @if($page=='leagueMake')
            <div class="card-header">{{__('messages.create_league')}}</div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'AdminController@leagueMake'])}}
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
                    </table>
                {{ Form::submit(__('messages.create'))}}
                {{ Form::close() }}
            </div>
            @endif
            @if($page=='teamMake')
            <div class="card-header">{{__('messages.create_team')}}</div>
            <div class="card-body">
                {{ Form::open([ 'method' => 'post' , 'action' => 'AdminController@teamMake'])}}
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
                    </table>
                {{ Form::submit(__('messages.create')) }}
                {{ Form::close() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection