@extends('layouts.copy')
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
            <div class="card-header">Menu @if($season!=NULL) for {{$season->seasonName}} season @endif</div>
            <div class="card-body">
                <p><a class="btn btn-primary @if($page=='home') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=home')}}'>Home</a></p>
                <p><a class="btn btn-primary @if($page=='roster') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=roster')}}'>Team Roster</a></p>
                <p><a class="btn btn-primary @if($page=='contracts') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=contracts')}}'>Contracts</a></p>
                <p><a class="btn btn-primary @if($page=='trades') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=trades')}}'>Trade Center</a></p>
                <p><a class="btn btn-primary @if($page=='agency') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=agency')}}'>Free agency</a></p>
                <p><a class="btn btn-primary @if($page=='games') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=games')}}'>Games</a></p>
                <p><a class="btn btn-primary @if($page=='stats') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=regular')}}'>Player Statistics</a></p>
            </div>
        </div>
    </div>
    @if($page=='home')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{$info->teamName}}</div>

            <div class="card-body">
                @if($nextGame)
                Next game:<a href='{{url('games='.$nextGame->id.'/log')}}'> @if($info->id==$nextGame->HostTeam)Hosting @else At @endif {{$opponent->teamName}} on {{$nextGame->date}}</a>
                <br> <a href='{{url('games='.$nextGame->id.'/roster')}}'> Upload Roster</a>
                @endif
                @if($info->statistician==NULL)
                <?php 
                    $user = App\User::where('role','=',3)->pluck('name','id');
                ?>
                <p>
                <h4>Add a Statistician</h4>
                    @if(count($user)>0)
                    <table>
                    {{ Form::open([ 'method' => 'post' , 'action' => ['TeamController@statistician',$info->id]])}}
                    <tr>
                        <td>{{ Form::label('statistician', 'Statistician:') }}</td>
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
                    {{ Form::submit('Add') }}
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
            <div class="card-header">Roster</div>
            <div class="card-body">
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goalie</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Birthday</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Height</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Weight</td>
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
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Defenceman</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Birthday</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Height</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Weight</td>
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
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Forward</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Birthday</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Height</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Weight</td>
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
            <div class="card-header">Contracts</div>
            <div class="card-body">
                <table>
                    <?php $total=0; ?>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goalie</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Cap Hit</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Years</td>
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
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">Extend</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('player='.$player->id.'/release')}}'">Release</div></td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Defenceman</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Cap Hit</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Years</td>
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
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">Extend</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('player='.$player->id.'/release')}}'">Release</div></td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Forward</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Cap Hit</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Years</td>
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
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">Extend</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('player='.$player->id.'/release')}}'">Release</div></td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'></td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Total:</td>
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
            <div class="card-header">Trade Center</div>

            <div class="card-body">
                Trades
            </div>
        </div>
    </div>
    @endif
    @if($page=='agency')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Free Agency</div>

            <div class="card-body">
                <?php 
                    $temp = App\Player::where('team','=',NULL)->get();
                ?>
                @if(count($temp)>0)
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>#</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Player</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Position</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Birthday</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Height</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Weight</td>
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
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('team='.$info->id.'/sign='.$player->id)}}'">Sign</div></td>
                    </tr>
                    @endif
                    @endforeach
                @else
                There are no free agents.
                @endif
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($page=='games')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Games</div>

            <div class="card-body">
            @if(count($games)>0)
                <p><h4>Regular season</h4></p>
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
                        <td style='border:solid; border-width:1px; width:600px;'>{{$league->leagueName}} {{$season->seasonName}} - {{$game->date}} - {{$host->teamName}} vs {{$visit->teamName}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL){{$game->HomeScore}} : {{$game->VisitorScore}} @endif</td>
                    </tr>
                @endif
                @endforeach
                </table>
                <p><h4>Play-offs</h4></p>
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
                        <td style='border:solid; border-width:1px; width:600px;'>{{$league->leagueName}} {{$season->seasonName}} - {{$game->date}} - {{$host->teamName}} vs {{$visit->teamName}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL){{$game->HomeScore}} : {{$game->VisitorScore}} @endif</td>
                    </tr>
                @endif
                @endforeach
                </table>
            @else 
            There are no games.
            @endif
            </div>
        </div>
    </div>
    @endif
    @if($page=='regular' || $page=='playoff')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Player Statistics</div>
            <div class="card-body">
                <p><div class="btn btn-primary @if($page=='regular') active @endif" style='width:49%;' onclick="location.href='{{url('team='.$info->id.'/page=regular')}}'">Regular Season</div>
                <div class="btn btn-primary @if($page=='playoff') active @endif" style='width:49%;' onclick="location.href='{{url('team='.$info->id.'/page=playoff')}}'"}}'>Play offs</div></p>
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goalie</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Games</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Shots on Goal</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goals allowed</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goals Against average</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Save Percentage</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Shutouts</td>
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
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Defenceman</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Games</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goals</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Asists</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Points</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Penalties in minutes</td>
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
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Forward</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Games</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Goals</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Asists</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Points</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>Penalties in minutes</td>
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
            <div class="card-header">Warning</div>
            <div class="card-body">
                This team does not belong to you!
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
            <div class="card-header">Team Maker</div>

            <div class="card-body">
                <?php 
                    $user = Auth::user()->toArray();
                    $id = $user['id'];
                ?>
                {{ Form::open([ 'method' => 'post' , 'action' => 'TeamController@store'])}}
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
                    </table>
                {{ Form::submit('Create') }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@endif
