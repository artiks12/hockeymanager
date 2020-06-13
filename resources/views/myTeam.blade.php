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
?>
@if($user['id']==$info->manager)
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Menu</div>
            <div class="card-body">
                <p><a class="btn btn-primary @if($page=='home') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=home')}}'>Home</a></p>
                <p><a class="btn btn-primary @if($page=='roster') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=roster')}}'>Team Roster</a></p>
                <p><a class="btn btn-primary @if($page=='contracts') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=contracts')}}'>Contracts</a></p>
                <p><a class="btn btn-primary @if($page=='trades') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=trades')}}'>Trade Center</a></p>
                <p><a class="btn btn-primary @if($page=='agency') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=agency')}}'>Free agency</a></p>
                <p><a class="btn btn-primary @if($page=='games') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=games')}}'>Games</a></p>
                <p><a class="btn btn-primary @if($page=='stats') active @endif" style='width:100%;' href='{{url('team='.$info->id.'/page=stats')}}'>Player Statistics</a></p>
            </div>
        </div>
    </div>
    @if($page=='home')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{$info->teamName}}</div>

            <div class="card-body">
                Next Game: @if($info->id==$nextGame->HostTeam)Hosting {{$teams[$nextGame->VisitingTeam-1]['teamName']}}@else At {{$teams[$nextGame->HostTeam-1]['teamName']}}@endif 
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
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
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
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
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
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
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
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Years}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary">Extend</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary">Release</div></td>
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
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Years}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary">Extend</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary">Release</div></td>
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
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->Years}}</td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary">Extend</div></td>
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary">Release</div></td>
                    </tr>
                    @endif
                    @endforeach
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
                        <td style='border:solid; border-width:1px;'><div class="btn btn-secondary" onclick="location.href='{{url('players')}}'">Sign</div></td>
                    </tr>
                    @endif
                    @endforeach
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
                <table>
                @foreach($games as $game)
                    <?php
                        $season = App\Season::where('id','=',$game->season)->first();
                        $league = App\League::where('id','=',$season->league)->first();
                        $host = App\Team::where('id','=',$game->HostTeam)->first();
                        $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                    ?>
                @if($game->season==$info->season)
                    <tr onclick="location.href='{{url('home')}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px; width:600px;'>{{$league->leagueName}} {{$season->seasonName}} - {{$game->date}} - {{$host->teamName}} vs {{$visit->teamName}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL){{$game->HomeScore}} : {{$game->VisitorScore}} @endif</td>
                    </tr>
                @endif
                @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif
    @if($page=='stats')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Player Statistics</div>

            <div class="card-body">
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
                            $games += $goalie->games;
                            $shots += $goalie->SOG;
                            $goals += $goalie->GA;
                            $shutouts += $goalie->shutouts;
                            $seconds += $goalie->seconds;
                        }
                        $average = 0;
                        $percentage = 0;
                        if($seconds != 0) $average = $goals*3600/$seconds;
                        if($shots != 0) $percentage = ($shots-$goals)*100/$shots;
                    ?>
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
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
                        foreach($fields as $field)
                        {
                            $games += $field->games;
                            $assists += $field->asists;
                            $goals += $field->goals;
                            $coeficient += $field->plus/minus;
                            $penalties += $field->PIM;
                        }
                        $points = $goals+$assists;
                    ?>
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
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
                        foreach($fields as $field)
                        {
                            $games += $field->games;
                            $assists += $field->asists;
                            $goals += $field->goals;
                            $coeficient += $field->plus/minus;
                            $penalties += $field->PIM;
                        }
                        $points = $goals+$assists;
                    ?>
                    <tr onclick="location.href='{{url('players')}}'" style="cursor:pointer;">
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
