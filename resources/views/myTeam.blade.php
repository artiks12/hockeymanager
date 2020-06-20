@extends('layouts.copy')
@if(!Auth::guest())
<style>
    div.games
    {
        display:none;
    }
</style>
@if($league==1)
<?php 
    $user = Auth::user()->toArray();
    $season = App\Season::where('id','=',$info->season)->first();
?>
@if($user['id']==$info->manager)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">@if($season!=NULL) {{__('messages.menu')}} {{__('messages.for')}} {{$season->seasonName}} {{__('messages.for_season')}} @endif</div>
            <div class="card-body">
                <p><a class="btn btn-primary @if($page=='home') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=home')}}'>{{__('messages.home')}}</a></p>
                <p><a class="btn btn-primary @if($page=='roster') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=roster')}}'>{{__('messages.team_roster')}}</a></p>
                <p><a class="btn btn-primary @if($page=='contracts') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=contracts')}}'>{{__('messages.contracts')}}</a></p>
                <p><a class="btn btn-primary @if($page=='trades') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=trades')}}'>{{__('messages.trade_center')}}</a></p>
                <p><a class="btn btn-primary @if($page=='agency') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=agency')}}'>{{__('messages.free_agency')}}</a></p>
                <p><a class="btn btn-primary @if($page=='games') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=games')}}'>{{__('messages.games')}}</a></p>
                <p><a class="btn btn-primary @if($page=='stats') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=regular')}}'>{{__('messages.player_statistics')}}</a></p>
            </div>
        </div>
    </div>
    @if($page=='home')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{$info->teamName}}</div>

            <div class="card-body">
                <?php 
                    date_default_timezone_set('Europe/Riga');
                    $date = date('Y-m-d H:i:s');
                ?>
                @if($nextGame)
                @if(strtotime($nextGame->date) > strtotime($date))
                @if(!App\Goalie::where('game','=',$nextGame->id)->exists())
                {{__('messages.next_game')}}:<a href='{{url('games='.$nextGame->id.'/log')}}'> @if($info->id==$nextGame->HostTeam){{__('messages.hosting')}} @else {{__('messages.at')}} @endif {{$opponent->teamName}} {{__('messages.on')}} {{$nextGame->date}}</a>
                <br> <a href='{{url('games='.$nextGame->id.'/roster')}}'> {{__('messages.upload_roster')}}</a>
                @endif
                @endif
                @endif
                @if($info->statistician==NULL)
                <?php 
                    $user = App\User::where('role','=',3)->pluck('name','id');
                ?>
                <p>
                <h4>{{__('messages.add_statistician')}}</h4>
                    @if(count($user)>0)
                    <table>
                    {{ Form::open([ 'method' => 'post' , 'action' => ['TeamController@statistician',$info->id]])}}
                    <tr>
                        <td>{{ Form::label('statistician', __('messages.statistician').':') }}</td>
                        <td>{{ Form::select('statistician', $user, ['class' => 'form-control'.
                        ($errors-> has('statistician') ? ' is-invalid' : '' )]) }}
                        @if ($errors-> has('statistician'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('statistician') }}</strong>
                            </span>
                        @endif
                        </td>
                    </tr>
                    </table>
                    {{ Form::submit(__('messages.add')) }}
                    {{ Form::close() }}
                    @endif
                </p>
                @endif
            </div>
        </div>
    </div>
    @endif
    @if($page=='roster')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.roster')}}</div>
            <div class="card-body">
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goalie')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='G' && $player->team==$info->id)
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.defenceman')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='D' && $player->team==$info->id)
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.forward')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='F' && $player->team==$info->id)
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($page=='contracts')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.contracts')}}</div>
            <div class="card-body">
                <table>
                    <?php $total=0; ?>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goalie')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.cap_hit')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.years')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='G' && $player->team==$info->id)
                    <?php $total+=$player->Cap; ?>
                    <tr>
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Years}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">{{__('messages.extend')}}</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('player='.$player->id.'/release')}}'">{{__('messages.release')}}</div></td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.defenceman')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.cap_hit')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.years')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='D' && $player->team==$info->id)
                    <?php $total+=$player->Cap; ?>
                    <tr>
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Years}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">{{__('messages.extend')}}</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('player='.$player->id.'/release')}}'">{{__('messages.release')}}</div></td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.forward')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.cap_hit')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.years')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='F' && $player->team==$info->id)
                    <?php $total+=$player->Cap; ?>
                    <tr>
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Years}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">{{__('messages.extend')}}</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('player='.$player->id.'/release')}}'">{{__('messages.release')}}</div></td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.total')}}:</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$total}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($page=='trades')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.trade_center')}}</div>

            <div class="card-body">
                Trades
            </div>
        </div>
    </div>
    @endif
    @if($page=='agency')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.free_agency')}}</div>

            <div class="card-body">
                <?php 
                    $temp = App\Player::where('team','=',NULL)->get();
                ?>
                @if(count($temp)>0)
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>#</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.player')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.position')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->team==NULL)
                    <tr>
                        <td style='border:solid; border-width:1px;'>{{$loop->index}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->position}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">{{__('messages.sign')}}</div></td>
                    </tr>
                    @endif
                    @endforeach
                @else
                {{__('messages.there_are_no_free_agents')}}
                @endif
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($page=='games')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.games')}}</div>

            <div class="card-body">
            @if(count($games)>0)
                <p><h4>{{__('messages.regular_season')}}</h4></p>
                <table>
                @foreach($games as $game)
                    <?php
                        $season = App\Season::where('id','=',$game->season)->first();
                        $league = App\League::where('id','=',$season->league)->first();
                        $host = App\Team::where('id','=',$game->HostTeam)->first();
                        $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                    ?>
                @if($game->season==$info->season && $game->type==1)
                    <tr onclick="location.href='{{url('games='.$game->id.'/log')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px; width:600px;'>{{$league->leagueName}} {{$season->seasonName}} - {{$game->date}} - {{$host->teamName}} {{__('messages.vs')}} {{$visit->teamName}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL){{$game->HomeScore}} : {{$game->VisitorScore}} @endif</td>
                    </tr>
                @endif
                @endforeach
                </table>
                <p><h4>{{__('messages.play-off')}}</h4></p>
                <table>
                @foreach($games as $game)
                    <?php
                        $season = App\Season::where('id','=',$game->season)->first();
                        $league = App\League::where('id','=',$season->league)->first();
                        $host = App\Team::where('id','=',$game->HostTeam)->first();
                        $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                    ?>
                @if($game->season==$info->season && $game->type==2)
                    <tr onclick="location.href='{{url('games='.$game->id.'/log')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px; width:600px;'>{{$league->leagueName}} {{$season->seasonName}} - {{$game->date}} - {{$host->teamName}} {{__('messages.vs')}} {{$visit->teamName}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL){{$game->HomeScore}} : {{$game->VisitorScore}} @endif</td>
                    </tr>
                @endif
                @endforeach
                </table>
            @else 
            {{__('messages.there_are_no_games')}}
            @endif
            </div>
        </div>
    </div>
    @endif
    @if($page=='regular' || $page=='playoff')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.player_statistics')}}</div>
            <div class="card-body">
                <p><div class="btn btn-primary @if($page=='regular') active @endif" style='width:49%;' onclick="location.href='{{url('team='.$info->id.'/page=regular')}}'">{{__('messages.regular_season')}}</div>
                <div class="btn btn-primary @if($page=='playoff') active @endif" style='width:49%;' onclick="location.href='{{url('team='.$info->id.'/page=playoff')}}'"}}'>{{__('messages.play-off')}}</div></p>
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goalie')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_aggainst_average')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.save_percentage')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.shutouts')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='G' && $player->team==$info->id)
                    <?php
                        $goalies = App\Goalie::where('season','=',$info->season)->where('player','=',$player->id)->get();
                        $games = 0;
                        $shots = 0;
                        $goals = 0;
                        $shutouts = 0;
                        $seconds = 0;
                        foreach($goalies as $goalie)
                        {
                            $game = App\Game::where('id','=',$goalie->game)->first();
                            if(($page=='regular' && $game->type==1) || ($page=='playoff' && $game->type==2))
                            {
                                $games += $goalie->games;
                                $shots += $goalie->SOG;
                                $goals += $goalie->GA;
                                $shutouts += $goalie->shutouts;
                                $seconds += $goalie->seconds;
                            }
                        }
                        $average = 0;
                        $percentage = 0;
                        if($seconds != 0) $average = number_format(($goals*3600/$seconds), 2, '.', '');
                        if($shots != 0) $percentage = number_format((($shots-$goals)*100/$shots), 2, '.', '');
                    ?>
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$games}}</td>
                        <td style='border:solid; border-width:1px;'>{{$shots}}</td>
                        <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                        <td style='border:solid; border-width:1px;'>{{$average}}</td>
                        <td style='border:solid; border-width:1px;'>{{$percentage}}</td>
                        <td style='border:solid; border-width:1px;'>{{$shutouts}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.defenceman')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='D' && $player->team==$info->id)
                    <?php
                        $fields = App\Field::where('season','=',$info->season)->where('player','=',$player->id)->get();
                        $games = 0;
                        $goals = 0;
                        $assists = 0;
                        $coeficient = 0;
                        $penalties = 0;
                        foreach($fields as $stats)
                        {
                            $game = App\Game::where('id','=',$goalie->game)->first();
                            if(($page=='regular' && $game->type==1) || ($page=='playoff' && $game->type==2))
                            {  
                                $games += $stats->games;
                                $assists += $stats->assists;
                                $goals += $stats->goals;
                                $coeficient += $stats->plus_minus;
                                $penalties += $stats->PIM;
                            }
                        }
                        $points = $goals+$assists;
                    ?>
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$games}}</td>
                        <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                        <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                        <td style='border:solid; border-width:1px;'>{{$points}}</td>
                        <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                        <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.forward')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='F' && $player->team==$info->id)
                    <?php
                        $fields = App\Field::where('season','=',$info->season)->where('player','=',$player->id)->get();
                        $games = 0;
                        $goals = 0;
                        $assists = 0;
                        $coeficient = 0;
                        $penalties = 0;
                        foreach($fields as $stats)
                        {
                            $game = App\Game::where('id','=',$goalie->game)->first();
                            if(($page=='regular' && $game->type==1) || ($page=='playoff' && $game->type==2))
                            {
                                $games += $stats->games;
                                $assists += $stats->assists;
                                $goals += $stats->goals;
                                $coeficient += $stats->plus_minus;
                                $penalties += $stats->PIM;
                            }
                        }
                        $points = $goals+$assists;
                    ?>
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$games}}</td>
                        <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                        <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                        <td style='border:solid; border-width:1px;'>{{$points}}</td>
                        <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                        <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@else
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.warning')}}</div>
            <div class="card-body">
                {{__('messages.this_team_does_not_belong_to_you')}}
            </div>
        </div>
    </div>
</div>
@endsection
@endif
@else
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{__('messages.team_maker')}}</div>

            <div class="card-body">
                <?php 
                    $user = Auth::user()->toArray();
                    $id = $user['id'];
                ?>
                {{ Form::open([ 'method' => 'post' , 'action' => 'TeamController@store'])}}
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
        </div>
    </div>
</div>
@endsection
@endif
@else
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{__('messages.warning')}}</div>
            <div class="card-body">
                {{__('messages.you_cannot_access_this_page')}}
            </div>
        </div>
    </div>
</div>
@endsection
@endif