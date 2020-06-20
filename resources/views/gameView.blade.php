@extends('layouts.copy')
<style>
    div.games
    {
        display:none;
    }
    table.log td
    {
        border:solid;
        border-width:2px;
        font-size:24px;
    }
    table.protocol td
    {
        border:solid;
        border-width:2px;
        font-size:18px;
    }
    table.protocol th
    {
        border:solid;
        border-width:2px;
        font-size:18px;
        font-weight:bold;
        width:30px;
    }
    table.protocol td
    {
        border:solid;
        border-width:2px;
        font-size:18px;
        width:30px;
    }
    .foo
    {
        width:75px;
    }
</style>
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$host->teamName}} {{__('messages.vs')}} {{$visit->teamName}} {{$game->date}}</div>
            <div class="card-body">
                <table class='log'>
                    <tr>
                        <td>{{__('messages.team')}}</td>
                        <td>{{__('messages.1st')}}</td>
                        <td>{{__('messages.2nd')}}</td>
                        <td>{{__('messages.3rd')}}</td>
                        @if($overtime>=1)
                        <td>{{__('messages.ot')}}</td>
                        @endif
                        @if($overtime==2)
                        <td>{{__('messages.shootout')}}</td>
                        @endif
                        <td>{{__('messages.total')}}</td>
                    </tr>
                    <tr>
                        <td>{{$host->teamName}}</td>
                        <td>{{$hostGoals[0]}}</td>
                        <td>{{$hostGoals[1]}}</td>
                        <td>{{$hostGoals[2]}}</td>
                        @if($overtime>=1)
                        <td>{{$hostGoals[3]}}</td>
                        @endif
                        @if($overtime==2)
                        <td>{{$hostGoals[4]}}</td>
                        @endif
                        <td>{{$hostGoals[0]+$hostGoals[1]+$hostGoals[2]+$hostGoals[3]+$hostGoals[4]}}</td>
                    </tr>
                    <tr>
                        <td>{{$visit->teamName}}</td>
                        <td>{{$visitGoals[0]}}</td>
                        <td>{{$visitGoals[1]}}</td>
                        <td>{{$visitGoals[2]}}</td>
                        @if($overtime>=1)
                        <td>{{$visitGoals[3]}}</td>
                        @endif
                        @if($overtime==2)
                        <td>{{$visitGoals[4]}}</td>
                        @endif
                        <td>{{$visitGoals[0]+$visitGoals[1]+$visitGoals[2]+$visitGoals[3]+$visitGoals[4]}}</td>
                    </tr>
                </table>
                <p><div class="btn btn-primary @if($page=='log') active @endif" style='width:33%;' onclick="location.href='{{url('games='.$game->id.'/log')}}'">{{__('messages.log')}}</div>
                <div class="btn btn-primary @if($page=='stats') active @endif" style='width:33%;' onclick="location.href='{{url('games='.$game->id.'/stats')}}'"}}'>{{__('messages.stats')}}</div>
                @if(!Auth::guest())
                <?php 
                    $user = Auth::user();
                ?>
                    @if($user->role==3)
                        @if($host->statistician==$user->id || $visit->statistician==$user->id)
                        <div class="btn btn-primary @if($page=='update') active @endif" style='width:33%;' onclick="location.href='{{url('games='.$game->id.'/update')}}'"}}'>{{__('messages.update')}}</div>
                        @endif
                    @endif
                @endif
                </p>
            @if($page=='log')
            @if($events>0)
            <table class='log'>
                <tr>
                    <td>{{__('messages.time')}}</td>
                    <td>{{__('messages.team')}}</td>
                    <td>{{__('messages.event')}}</td>
                    <td>{{__('messages.description')}}</td>
                </tr>
                @if($events==3)
                @foreach($list as $note)
                <tr>
                    <?php 
                        $team = App\Team::where('id','=',$note->team)->first();
                        $mod = ($note->second)%60;
                    ?>
                    <td>{{intval(($note->second)/60)}}:<?php if($mod<10){echo '0';}?>{{($note->second)%60}}</td>
                    <td>{{$team->teamName}}</td>
                    @if($note->scorer)
                    <?php 
                        $scorer = App\Player::where('id','=',$note->scorer)->first(); 
                        if($note->assist_1!=NULL){$assist1 = App\Player::where('id','=',$note->assist_1)->first();}
                        if($note->assist_2!=NULL){$assist2 = App\Player::where('id','=',$note->assist_2)->first();}
                        if($note->goalie!=NULL){$goalie = App\Player::where('id','=',$note->goalie)->first();}
                    ?>
                    <td>{{__('messages.goal')}}</td>
                    <td>{{__('messages.scorer')}}: {{$scorer->name}} {{$scorer->surname}} @if($note->assist_1!=NULL)<br> {{__('messages.assisted')}}: {{$assist1->name}} {{$assist1->surname}} @endif @if($note->assist_2!=NULL) and {{$assist2->name}} {{$assist2->surname}} @endif <br>{{__('messages.goalie')}}: @if($note->goalie!=NULL) {{$goalie->name}} {{$goalie->surname}} @else {{__('messages.empty_net')}} @endif</td>
                    @else
                    <?php 
                        $player = App\Player::where('id','=',$note->player)->first();
                    ?>
                    <td>{{__('messages.penalty')}}</td>
                    <td>{{$player->name}} {{$player->surname}} {{__('messages.gets')}} {{$note->minutes}} {{__('messages.minutes_for')}} {{$note->reason}}</td>
                    @endif
                </tr>
                @endforeach
                @endif
                @if($events==2)
                @foreach($goals as $goal)
                <tr>
                    <?php 
                        $scorer = App\Player::where('id','=',$goal->scorer)->first(); 
                        if($goal->assist_1!=NULL){$assist1 = App\Player::where('id','=',$goal->assist_1)->first();}
                        if($goal->assist_2!=NULL){$assist2 = App\Player::where('id','=',$goal->assist_2)->first();}
                        if($goal->goalie!=NULL){$goalie = App\Player::where('id','=',$goal->goalie)->first();}
                        $team = App\Team::where('id','=',$goal->team)->first();
                        $mod = ($note->second)%60;
                    ?>
                    <td>{{intval(($goal->second)/60)}}:<?php if($mod<10){echo '0';}?>{{($goal->second)%60}}</td>
                    <td>{{$team->teamName}}</td>
                    <td>{{__('messages.goal')}}</td>
                    <td>{{__('messages.scorer')}}: {{$scorer->name}} {{$scorer->surname}} @if($note->assist_1!=NULL)<br> {{__('messages.assisted')}}: {{$assist1->name}} {{$assist1->surname}} @endif @if($note->assist_2!=NULL) and {{$assist2->name}} {{$assist2->surname}} @endif <br>{{__('messages.goalie')}}: @if($note->goalie!=NULL) {{$goalie->name}} {{$goalie->surname}} @else {{__('messages.empty_net')}} @endif</td>
                </tr>
                @endforeach
                @endif
                @if($events==1)
                @foreach($penalties as $penalty)
                    <tr>
                        <?php 
                            $team = App\Team::where('id','=',$note->team)->first();
                            $mod = ($note->second)%60;
                        ?>
                        <td>{{intval(($note->second)/60)}}:<?php if($mod<10){echo '0';}?>{{($note->second)%60}}</td>
                        <td>{{$team->teamName}}</td>
                        <?php 
                            $player = App\Player::where('id','=',$note->player)->first();
                        ?>
                        <td>{{__('messages.penalty')}}</td>
                        <td>{{$player->name}} {{$player->surname}} {{__('messages.gets')}} {{$note->minutes}} {{__('messages.minutes_for')}} {{$note->reason}}</td>
                    </tr>
                @endforeach
                @endif
            </table>
            @endif
            @endif
            @if($page=='stats')
                @if(count($homeField)+count($homeGoalie)>0)
                <?php 
                    $home = App\Team::where('id','=',$game->HostTeam)->first();
                    $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                ?>
                    <p><h4>{{$home->teamName}}</h4></p>
                    <table>
                    @if(count($homeGoalie)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goalie')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.time_on_ice')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($homeGoalie as $stat)
                            <?php 
                                $player = App\Player::where('id','=',$stat->player)->first();
                            ?>
                            <tr onclick="location.href='{{url('players='.$player->id)}}'">
                                <td style='border:solid; border-width:1px;'>{{intval($player->number)}}</td>
                                <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->SOG)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->GA)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval(($stat->seconds)/60)}}:<?php if($stat->seconds%60<10){echo '0';}?>{{intval(($stat->seconds)%60)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->Assists)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->PIM)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if(count($homeField)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.player')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($homeField as $stat)
                            <?php 
                                $player = App\Player::where('id','=',$stat->player)->first();
                            ?>
                            <tr onclick="location.href='{{url('players='.$player->id)}}'">
                                <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                                <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->goals}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->assists}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->goals+$stat->assists}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->plus_minus}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </table>
                @endif
                @if(count($visitField)+count($visitGoalie)>0)
                    <p><h4>{{$visit->teamName}}</h4></p>
                    <table>
                    @if(count($visitGoalie)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goalie')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.time_on_ice')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($visitGoalie as $stat)
                            <?php 
                                $player = App\Player::where('id','=',$stat->player)->first();
                            ?>
                            <tr onclick="location.href='{{url('players='.$player->id)}}'">
                                <td style='border:solid; border-width:1px;'>{{intval($player->number)}}</td>
                                <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->SOG)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->GA)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval(($stat->seconds)/60)}}:<?php if($stat->seconds%60<10){echo '0';}?>{{intval(($stat->seconds)%60)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->Assists)}}</td>
                                <td style='border:solid; border-width:1px;'>{{intval($stat->PIM)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if(count($visitField)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.player')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($visitField as $stat)
                            <?php 
                                $player = App\Player::where('id','=',$stat->player)->first();
                            ?>
                            <tr onclick="location.href='{{url('players='.$player->id)}}'">
                                <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                                <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->goals}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->assists}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->goals+$stat->assists}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->plus_minus}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </table>
                @endif
            @endif
            @if($page=='roster')
            <h4>{{__('messages.roster_upload')}}:</h4>
            {{ Form::open([ 'method' => 'post' , 'action' => ['GameController@roster', $game->id, $team->id]])}}
                    <table>
                        <tr><td><h5>{{__('messages.goalies')}}:</h5></td><td></td></tr>
                        @foreach($roster as $player)
                        @if($player->position=='G' && $player->Cap!=NULL)
                            <tr>
                                <td>{{ Form::label('goalies[]', $player->name.' '.$player->surname) }}</td>
                                <td>{{ Form::checkbox(('goalies[]'), $player->id) }}</td>
                            </tr>
                        @endif
                        @endforeach
                        
                        <tr><td><h5>{{__('messages.defencemen')}}:</h5></td><td></td></tr>
                        @foreach($roster as $player)
                        @if($player->position=='D' && $player->Cap!=NULL)
                            <tr>
                                <td>{{ Form::label('defencemen[]', $player->name.' '.$player->surname) }}</td>
                                <td>{{ Form::checkbox(('defencemen[]'), $player->id) }}</td>
                            </tr>
                        @endif
                        @endforeach
                        
                        <tr><td><h5>{{__('messages.forwards')}}:</h5></td><td></td></tr>
                        @foreach($roster as $player)
                        @if($player->position=='F' && $player->Cap!=NULL)
                            <tr>
                                <td>{{ Form::label('forwards[]', $player->name.' '.$player->surname) }}</td>
                                <td>{{ Form::checkbox(('forwards[]'), $player->id) }}</td>
                            </tr>
                        @endif
                        @endforeach
                    </table>
                {{ Form::submit(__('messages.add')) }}
                {{ Form::close() }}
            @endif
            @if($page=='update')
                <p>
                <?php
                $date = Date('Y-m-d H:i:s');
                ?>
                @if(strtotime($date)< strtotime($game->date))
                    {{__('messages.the_game_hasnt_started_yet')}}
                @elseif($game->HomeScore == NULL && $game->VisitorScore==NULL)
                <h4>{{__('messages.add_goal')}}:</h4>
                {{ Form::open([ 'method' => 'post', 'action' => ['GameController@addGoal',$game->id,$team->id]])}}
                    <table class='log'>
                        <tr>
                            <td>{{__('messages.second')}}</td>
                            <td>{{__('messages.scorer')}}</td>
                            <td>{{__('messages.1st_assist')}}</td>
                            <td>{{__('messages.2nd_assist')}}</td>
                            <td>{{__('messages.goalie')}}</td>
                        </tr>
                        <tr>
                            <td>{{ Form::number('time1', '', ['class' => 'form-control'.
                            ($errors-> has('time1') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('time1'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('time1') }}</strong>
                                </span>
                            @endif
                            </td>
                            <td>
                                <select name='scorrer' id='scorrer'>
                                    @foreach($players as $player)
                                    <?php 
                                        $temp = App\Player::where('id','=',$player->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                    @foreach($goalies as $goalie)
                                    <?php 
                                        $temp = App\Player::where('id','=',$goalie->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name='assist1' id='assist1'>
                                    <option  value='0'>none</option>
                                    @foreach($players as $player)
                                    <?php 
                                        $temp = App\Player::where('id','=',$player->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                    @foreach($goalies as $goalie)
                                    <?php 
                                        $temp = App\Player::where('id','=',$goalie->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name='assist2' id='assist2'>
                                    <option  value='0'>none</option>
                                    @foreach($players as $player)
                                    <?php 
                                        $temp = App\Player::where('id','=',$player->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                    @foreach($goalies as $goalie)
                                    <?php 
                                        $temp = App\Player::where('id','=',$goalie->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name='goalie' id='goalie'>
                                    <option value='0'>none</option>
                                    @foreach($against as $player)
                                    <?php 
                                        $temp = App\Player::where('id','=',$player->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                {{ Form::submit(__('messages.add')) }}
                {{ Form::close() }}
                <h4>{{__('messages.add_penalty')}}:</h4>
                {{ Form::open([ 'method' => 'post', 'action' => ['GameController@addPenalty',$game->id,$team->id]])}}
                    <table class='log'>
                        <tr>
                            <td>{{__('messages.second')}}</td>
                            <td>{{__('messages.player')}}</td>
                            <td>{{__('messages.minutes')}}</td>
                            <td>{{__('messages.reason')}}</td>
                        </tr>
                        <tr>
                            <td>{{ Form::number('time2', '', ['class' => 'form-control'.
                            ($errors-> has('time2') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('time2'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('time2') }}</strong>
                                </span>
                            @endif
                            </td>
                            <td>
                                <select name='player' id='player'>
                                    @foreach($players as $player)
                                    <?php 
                                        $temp = App\Player::where('id','=',$player->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                    @foreach($goalies as $goalie)
                                    <?php 
                                        $temp = App\Player::where('id','=',$goalie->player)->first();
                                    ?>
                                    <option value='{{$temp->id}}'>{{$temp->name}} {{$temp->surname}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{ Form::number('minutes', '', ['class' => 'form-control'.
                            ($errors-> has('minutes') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('minutes'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('minutes') }}</strong>
                                </span>
                            @endif
                            </td>
                            <td>{{ Form::text('reason', '', ['class' => 'form-control'.
                            ($errors-> has('reason') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('reason'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('reason') }}</strong>
                                </span>
                            @endif
                            </td>
                        </tr>
                    </table>
                {{ Form::submit(__('messages.add')) }}
                {{ Form::close() }}
                <div class="btn btn-primary @if($page=='update') active @endif" style='width:33%;' onclick="location.href='{{action('GameController@finish',$game->id)}}'"}}'>{{__('messages.finnish')}}</div>
                @else
                <h4>{{__('messages.insert_protocols')}}:</h4>
                <p>
                <?php 
                    $goalies = App\Goalie::where('game','=',$game->id)->where('team','=',$team->id)->where('is_set','=',0)->get();
                    $fields = App\Field::where('game','=',$game->id)->where('team','=',$team->id)->where('is_set','=',0)->get();
                ?>
                    @if(count($goalies)>0 && count($fields)>0)
                        @if(count($goalies)>0)
                        <table class='protocol'>
                            <tr>
                                <th>#</th>
                                <th>{{__('messages.goalie')}}</th>
                                <th>{{__('messages.games')}}</th>
                                <th>{{__('messages.wins')}}</th>
                                <th>{{__('messages.loses')}}</th>
                                <th>{{__('messages.sog')}}</th>
                                <th>{{__('messages.goals_allowed')}}</th>
                                <th>{{__('messages.seconds')}}</th>
                                <th>{{__('messages.shutouts')}}</th>
                                <th>{{__('messages.goals')}}</th>
                                <th>{{__('messages.assists')}}</th>
                                <th>{{__('messages.pim')}}</th>
                                <th>Insert</th>
                            </tr>
                            @foreach($goalies as $goalie)
                            <?php 
                                $temp = App\Player::where('id','=',$goalie->player)->first();
                            ?>
                            {{ Form::open(['class' => 'protocol', 'method' => 'post', 'action' => ['GameController@updateGoalie',$game->id,$team->id,$temp->id]])}}
                            <tr>
                                <td>{{$temp->number}}</td>
                                <td>{{$temp->name}} {{$temp->surname}}</td>
                                <td>{{ Form::input('number',$temp->number.'games', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'wins', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'loses', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'SOG', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'GA', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'Seconds', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'Shutouts', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'Goals', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'Assists', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'PIM', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::submit('Insert') }}</td>
                            </tr>
                            {{ Form::close() }}
                            @endforeach
                        </table>
                        </p>
                        @endif
                        @if(count($fields)>0)
                        <p>
                        <table class='protocol'>
                            <tr>
                                <th>#</th>
                                <th>{{__('messages.player')}}</th>
                                <th>{{__('messages.games')}}</th>
                                <th>{{__('messages.goals')}}</th>
                                <th>{{__('messages.assists')}}</th>
                                <th>+/-</th>
                                <th>{{__('messages.pim')}}</th>
                                <th>{{__('messages.faceoffs')}}</th>
                                <th>{{__('messages.faceoffs_won')}}</th>
                                <th>{{__('messages.shots')}}</th>
                                <th>{{__('messages.blocked_shots')}}</th>
                                <th>Insert</th>
                            </tr>
                            @foreach($fields as $goalie)
                            <?php 
                                $temp = App\Player::where('id','=',$goalie->player)->first();
                            ?>
                            {{ Form::open([ 'method' => 'post', 'action' => ['GameController@updateField',$game->id,$team->id,$temp->id]])}}
                            <tr>
                                <td>{{$temp->number}}</td>
                                <td>{{$temp->name}} {{$temp->surname}}</td>
                                <td>{{ Form::input('number',$temp->number.'games', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'Goals', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'Assists', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'plus_minus', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'PIM', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'faceoffs', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'faceoffsWon', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'shots', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::input('number',$temp->number.'blockedShots', null, array('class' => 'foo'))}}</td>
                                <td>{{ Form::submit('Insert') }}</td>
                            </tr>
                            {{ Form::close() }}
                            @endforeach
                        </table>
                        </p>
                        @endif
                    @else
                    {{__('messages.all_protocols_have_been_uploaded')}}d
                    @endif
                @endif
            @endif
            </div>
        </div>
    </div>
</div>
@endsection


                    
                