@extends('layouts.copy')

<?php 
    $season=App\Season::where('id','=',$info->season)->first();
?>
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$info->teamName}} {{__('messages.latest_season')}}: @if($info->season!=NULL){{$season->seasonName}}@else {{__('messages.none')}} @endif</div>
            <div class="card-body">
                <p><a class="btn btn-primary @if($page=='roster') active @endif" style='width:49%;' href='{{url('teams='.$info->id.'/page=roster')}}'>{{__('messages.team_roster')}}</a>
                <a class="btn btn-primary @if($page=='stats') active @endif" style='width:49%;' href='{{url('teams='.$info->id.'/page=stats')}}'>{{__('messages.player_statistics')}}</a></p>
                @if($page=='roster')
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goalie')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.cap_hit')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.years')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='G' && $player->team==$info->id)
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$player->Years}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.defenceman')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.cap_hit')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.years')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='D' && $player->team==$info->id)
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$player->Years}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.number')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.forward')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.birthday')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.height')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.weight')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.cap_hit')}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.years')}}</td>
                    </tr>
                    @foreach($players as $player)
                    @if($player->position=='F' && $player->team==$info->id)
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->birthday}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->height}}</td>
                        <td style='border:solid; border-width:1px;'>{{$player->weight}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$player->Cap}}</td>
                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{$player->Years}}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            @endif
            @if($page=='stats')
            <p>
            <h4>{{__('messages.regular_season')}}</h4>
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
                            if($game->type==1)
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
                            if($game->type==1)
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
                            if($game->type==1)
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
            </p>
            <p>
            <h4>{{__('messages.play-off')}}</h4>
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
                        if($game->type==2)
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
                        if($game->type==2)
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
                        if($game->type==2)
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
            </p>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

