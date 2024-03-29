@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$player->name}} {{$player->surname}}</div>

            <div class="card-body">
                <p>{{__('messages.birthday')}}: {{$player->birthday}}</p>
                <p>{{__('messages.height')}}: {{$player->height}}</p>
                <p>{{__('messages.weight')}}: {{$player->weight}}</p>
                <p>{{__('messages.team')}}: @if($player->team!=NULL){{$team->teamName}}@else {{__('messages.none')}} @endif</p>
                <br>
                @if($set==2)
                <p>
                    @if($player->position=='D' || $player->position=='F')
                    <h5>{{__('messages.regular_season')}}:</h5>
                    <table>
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.game')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($stats as $stat)
                        <?php
                            $game = App\Game::where('id','=',$stat->game)->first();
                            $season = App\Season::where('id','=',$game->season)->first();
                            $league = App\League::where('id','=', $season->league)->first();
                        ?>
                        @if($game->type==1)
                        <tr>
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$game->id}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->goals}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->goals+$stat->assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->plus_minus}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    </p>
                    <p>
                    <h5>{{__('messages.play-off')}}:</h5>
                    <table>
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.game')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($stats as $stat)
                        <?php
                            $game = App\Game::where('id','=',$stat->game)->first();
                            $season = App\Season::where('id','=',$game->season)->first();
                            $league = App\League::where('id','=', $season->league)->first();
                        ?>
                        @if($game->type==2)
                        <tt>
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$game->id}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->goals}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->goals+$stat->assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->plus_minus}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    @else
                    <h5>{{__('messages.regular_season')}}:</h5>
                    <table>
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.game')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_aggainst_average')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.save_percentage')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.time_on_ice')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.shutouts')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($stats as $stat)
                        <?php
                            $game = App\Game::where('id','=',$stat->game)->first();
                            $season = App\Season::where('id','=',$game->season)->first();
                            $league = App\League::where('id','=', $season->league)->first();
                        ?>
                        @if($game->type==1)
                        <tr>
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$game->id}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->SOG}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->GA}}</td>
                            <td style='border:solid; border-width:1px;'>@if($stat->seconds!=0){{number_format(($stat->GA*3600/$stat->seconds), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>@if($stat->SOG!=0){{number_format((($stat->SOG-$stat->GA)*100/$stat->SOG), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->seconds}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->shutouts}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->Goals}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->Assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    </p>
                    <p>
                    <h5>{{__('messages.play-off')}}:</h5>
                    <table>
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.game')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_aggainst_average')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.save_percentage')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.time_on_ice')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.shutouts')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($stats as $stat)
                        <?php
                            $game = App\Game::where('id','=',$stat->game)->first();
                            $season = App\Season::where('id','=',$game->season)->first();
                            $league = App\League::where('id','=', $season->league)->first();
                        ?>
                        @if($game->type==2)
                        <tt>
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$game->id}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->SOG}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->GA}}</td>
                            <td style='border:solid; border-width:1px;'>@if($stat->seconds!=0){{number_format(($stat->GA*3600/$stat->seconds), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>@if($stat->SOG!=0){{number_format((($stat->SOG-$stat->GA)*100/$stat->SOG), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->seconds}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->shutouts}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->Goals}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->Assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    @endif
                </p>
                @endif
                @if($set==1)
                <p>
                    <h5>{{__('messages.latest_season')}}:</h5>
                    <table>
                        @if($player->position=='D' || $player->position=='F')
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        <?php 
                            $index = $point;
                            $season = App\Season::where('id','=',$index)->first();
                            $league = App\League::where('id','=',$season->league)->first(); 
                            $games = 0;
                            $goals = 0;
                            $assists = 0;
                            $coeficient = 0;
                            $penalties = 0;
                            $points = 0;
                            $gamesP = 0;
                            $goalsP = 0;
                            $assistsP = 0;
                            $coeficientP = 0;
                            $penaltiesP = 0;
                            $pointsP = 0;
                        ?>
                        @foreach($stats as $stat)
                        <?php
                            $game = App\Game::where('id','=',$stat->game)->first();
                            if($loop->index==0)
                            {
                                
                            }
                            if($index==$stat->season)
                            {
                                if($game->type==1)
                                {
                                    $games += $stat->games;
                                    $assists += $stat->assists;
                                    $goals += $stat->goals;
                                    $coeficient += $stat->plus_minus;
                                    $penalties += $stat->PIM;
                                    $points = $goals+$assists;
                                }
                                else
                                {
                                    $gamesP += $stat->games;
                                    $assistsP += $stat->assists;
                                    $goalsP += $stat->goals;
                                    $coeficientP += $stat->plus_minus;
                                    $penaltiesP += $stat->PIM;
                                    $pointsP = $goalsP+$assistsP;
                                }
                                
                            }
                        ?>
                        @endforeach
                        <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$games}}</td>
                            <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                            <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$points}}</td>
                            <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                            <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                        </tr>
                        <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$pointsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$coeficientP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                        </tr>
                        <!-- GOALIE -->
                        @else
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_aggainst_average')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.save_percentage')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.time_on_ice')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.shutouts')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        <?php 
                            $index = $point;
                            $season = App\Season::where('id','=',$index)->first();
                            $league = App\League::where('id','=',$season->league)->first(); 
                            $games = 0;
                            $shots = 0;
                            $allowed = 0;
                            $seconds = 0;
                            $shutouts = 0;
                            $goals = 0;
                            $assists = 0;
                            $penalties = 0;
                            $gamesP = 0;
                            $shotsP = 0;
                            $allowedP = 0;
                            $secondsP = 0;
                            $shutoutsP = 0;
                            $goalsP = 0;
                            $assistsP = 0;
                            $penaltiesP = 0;
                        ?>
                        @foreach($stats as $stat)
                        <?php
                            $game = App\Game::where('id','=',$stat->game)->first();
                            if($loop->index==0)
                            {
                                
                            }
                            if($index==$stat->season)
                            {
                                if($game->type==1)
                                {
                                    $games = $stat->games;
                                    $shots = $stat->SOG;
                                    $allowed = $stat->GA;
                                    $seconds = $stat->seconds;
                                    $shutouts = $stat->shutouts;
                                    $goals = $stat->Goals;
                                    $assists = $stat->Assists;
                                    $penalties = $stat->PIM;
                                }
                                else
                                {
                                    $gamesP += $stat->games;
                                    $shotsP += $stat->SOG;
                                    $allowedP += $stat->GA;
                                    $secondsP += $stat->seconds;
                                    $shutoutsP += $stat->shutouts;
                                    $assistsP += $stat->Assists;
                                    $goalsP += $stat->Goals;
                                    $penaltiesP += $stat->PIM;
                                }
                                
                            }
                        ?>
                        @endforeach
                        <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$games}}</td>
                            <td style='border:solid; border-width:1px;'>{{$shots}}</td>
                            <td style='border:solid; border-width:1px;'>{{$allowed}}</td>
                            <td style='border:solid; border-width:1px;'>@if($seconds!=0){{number_format(($allowed*3600/$seconds), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>@if($shots!=0){{number_format((($shots-$allowed)*100/$shots), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>{{$seconds}}</td>
                            <td style='border:solid; border-width:1px;'>{{$shutouts}}</td>
                            <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                            <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                            <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                        </tr>
                        <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                            <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$shotsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$allowedP}}</td>
                            <td style='border:solid; border-width:1px;'>@if($secondsP!=0){{number_format(($allowedP*3600/$secondsP), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>@if($shotsP!=0){{number_format((($shotsP-$allowedP)*100/$shotsP), 2, '.', '')}} @else 0 @endif</td>
                            <td style='border:solid; border-width:1px;'>{{$secondsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$shutoutsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                            <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                        </tr>
                        @endif
                    </table>
                </p>
                <p>
                    <h5>{{__('messages.previous_seasons')}}:</h5>
                    @if($player->position=='D' || $player->position=='F')
                    <?php 
                        $rest = App\Field::where('season','!=',$index)->where('player','=',$player->id)->get();
                        $last = App\Field::where('season','!=',$index)->orderBy('id','desc')->first();
                        if(count($rest)>0){$index=$rest['0']['season'];}
                        $games = 0;
                        $goals = 0;
                        $assists = 0;
                        $coeficient = 0;
                        $penalties = 0;
                        $gamesP = 0;
                        $goalsP = 0;
                        $assistsP = 0;
                        $coeficientP = 0;
                        $penaltiesP = 0;
                        $pointsP = 0;
                    ?>
                    @if(count($rest)>0)
                    <table>
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.points')}}</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                        </tr>
                        @foreach($rest as $stat)
                            <?php 
                            $game = App\Game::where('id','=',$stat->game)->first();
                            ?>
                            @if($index==$stat->season && $last->id==$stat->id)
                                <?php 
                                    if($game->type==1)
                                    {
                                        $games += $stat->games;
                                        $assists += $stat->assists;
                                        $goals += $stat->goals;
                                        $coeficient += $stat->plus_minus;
                                        $penalties += $stat->PIM;
                                        $points = $goals+$assists;
                                    }
                                    else
                                    {
                                        $gamesP += $stat->games;
                                        $assistsP += $stat->assists;
                                        $goalsP += $stat->goals;
                                        $coeficientP += $stat->plus_minus;
                                        $penaltiesP += $stat->PIM;
                                        $pointsP = $goals+$assists;
                                    }
                                    $points = $goals+$assists;
                                    $season = App\Season::where('id','=',$index)->first();
                                    $league = App\League::where('id','=',$season->league)->first();
                                ?>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$points}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                </tr>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$pointsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficientP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                </tr>
                            @endif
                            @if($index!=$stat->season && $last->id==$stat->id)
                                <?php 
                                    $season = App\Season::where('id','=',$index)->first();
                                    $league = App\League::where('id','=',$season->league)->first(); 
                                ?>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$points}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                </tr>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$pointsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficientP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                </tr>
                                <?php 
                                    $index=$stat->season;
                                    $games = 0;
                                    $goals = 0;
                                    $assists = 0;
                                    $coeficient = 0;
                                    $penalties = 0;
                                    $gamesP = 0;
                                    $goalsP = 0;
                                    $assistsP = 0;
                                    $coeficientP = 0;
                                    $penaltiesP = 0;
                                    $pointsP = 0;
                                    if($game->type==1)
                                    {
                                        $games += $stat->games;
                                        $assists += $stat->assists;
                                        $goals += $stat->goals;
                                        $coeficient += $stat->plus_minus;
                                        $penalties += $stat->PIM;
                                        $points = $goals+$assists;
                                    }
                                    else
                                    {
                                        $gamesP += $stat->games;
                                        $assistsP += $stat->assists;
                                        $goalsP += $stat->goals;
                                        $coeficientP += $stat->plus_minus;
                                        $penaltiesP += $stat->PIM;
                                        $pointsP = $goals+$assists;
                                    }
                                    $points = $goals+$assists;
                                    $season = App\Season::where('id','=',$index)->first();
                                    $league = App\League::where('id','=',$season->league)->first();
                                ?>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$stat->season)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$points}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                </tr>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$stat->season)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$pointsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficientP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                </tr>
                            @endif
                            @if($index==$stat->season && $last->id!=$stat->id)
                            <?php
                                if($game->type==1)
                                    {
                                        $games += $stat->games;
                                        $assists += $stat->assists;
                                        $goals += $stat->goals;
                                        $coeficient += $stat->plus_minus;
                                        $penalties += $stat->PIM;
                                        $points = $goals+$assists;
                                    }
                                else
                                    {
                                        $gamesP += $stat->games;
                                        $assistsP += $stat->assists;
                                        $goalsP += $stat->goals;
                                        $coeficientP += $stat->plus_minus;
                                        $penaltiesP += $stat->PIM;
                                        $pointsP = $goals+$assists;
                                    }
                                $points = $goals+$assists;
                                $season = App\Season::where('id','=',$index)->first();
                                $league = App\League::where('id','=',$season->league)->first();
                            ?>
                            @endif
                            @if($last->id!=$stat->id && $index!=$stat->season)
                                <?php 
                                    $season = App\Season::where('id','=',$index)->first();
                                    $league = App\League::where('id','=',$season->league)->first(); 
                                ?>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$points}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficient}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                </tr>
                                <tr onclick="location.href='{{url('players='.$player->id.'/season='.$index)}}'" style="cursor:pointer;">
                                    <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$pointsP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$coeficientP}}</td>
                                    <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                </tr>
                                <?php 
                                    $index=$stat->season;
                                    $games = 0;
                                    $goals = 0;
                                    $assists = 0;
                                    $coeficient = 0;
                                    $penalties = 0;
                                    $gamesP = 0;
                                    $goalsP = 0;
                                    $assistsP = 0;
                                    $coeficientP = 0;
                                    $penaltiesP = 0;
                                    $pointsP = 0;
                                    if($game->type==1)
                                    {
                                        $games += $stat->games;
                                        $assists += $stat->assists;
                                        $goals += $stat->goals;
                                        $coeficient += $stat->plus_minus;
                                        $penalties += $stat->PIM;
                                        $points = $goals+$assists;
                                    }
                                    else
                                    {
                                        $gamesP += $stat->games;
                                        $assistsP += $stat->assists;
                                        $goalsP += $stat->goals;
                                        $coeficientP += $stat->plus_minus;
                                        $penaltiesP += $stat->PIM;
                                        $pointsP = $goals+$assists;
                                    }
                                ?>
                            @endif
                        @endforeach
                    </table>
                        @else
                            {{__('messages.there_are_no_statistics_from_previous_seasons')}}
                        @endif
                        <!-- GOALIE -->
                        @else
                            <?php 
                                $rest = App\Goalie::where('season','!=',$index)->where('player','=',$player->id)->get();
                                $last = App\Goalie::where('season','!=',$index)->orderBy('id','desc')->first();
                                if(count($rest)>0){$index=$rest['0']['season'];}
                                $games = 0;
                                $shots = 0;
                                $allowed = 0;
                                $seconds = 0;
                                $shutouts = 0;
                                $goals = 0;
                                $assists = 0;
                                $penalties = 0;
                                $gamesP = 0;
                                $shotsP = 0;
                                $allowedP = 0;
                                $secondsP = 0;
                                $shutoutsP = 0;
                                $goalsP = 0;
                                $assistsP = 0;
                                $penaltiesP = 0;
                            ?>
                            @if(count($rest)>0)
                                <table>
                                    <tr>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.league')}} {{__('messages.season')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.games')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.sog')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_allowed')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals_aggainst_average')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.save_percentage')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.time_on_ice')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.shutouts')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.goals')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.assists')}}</td>
                                        <td style='border:solid; border-width:1px; font-weight:bold;'>{{__('messages.pim')}}</td>
                                    </tr>
                                @foreach($rest as $stat)
                                    <?php 
                                    $game = App\Game::where('id','=',$stat->game)->first();
                                    ?>
                                    @if($index==$stat->season && $last->id==$stat->id)
                                        <?php 
                                            if($game->type==1)
                                            {
                                                $games = $stat->games;
                                                $shots = $stat->SOG;
                                                $allowed = $stat->GA;
                                                $seconds = $stat->seconds;
                                                $shutouts = $stat->shutouts;
                                                $goals = $stat->Goals;
                                                $assists = $stat->Assists;
                                                $penalties = $stat->PIM;
                                            }
                                            else
                                            {
                                                $gamesP += $stat->games;
                                                $shotsP += $stat->SOG;
                                                $allowedP += $stat->GA;
                                                $secondsP += $stat->seconds;
                                                $shutoutsP += $stat->shutouts;
                                                $assistsP += $stat->Assists;
                                                $goalsP += $stat->Goals;
                                                $penaltiesP += $stat->PIM;
                                            }
                                            $season = App\Season::where('id','=',$index)->first();
                                            $league = App\League::where('id','=',$season->league)->first();
                                        ?>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shots}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowed}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($seconds!=0){{number_format(($allowed*3600/$seconds), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shots!=0){{number_format((($shots-$allowed)*100/$shots), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$seconds}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutouts}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                        </tr>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shotsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowedP}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($secondsP!=0){{number_format(($allowedP*3600/$secondsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shotsP!=0){{number_format((($shotsP-$allowedP)*100/$shotsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$secondsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutoutsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                        </tr>
                                    @endif
                                    @if($index!=$stat->season && $last->id==$stat->id)
                                        <?php 
                                            $season = App\Season::where('id','=',$index)->first();
                                            $league = App\League::where('id','=',$season->league)->first(); 
                                        ?>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shots}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowed}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($seconds!=0){{number_format(($allowed*3600/$seconds), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shots!=0){{number_format((($shots-$allowed)*100/$shots), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$seconds}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutouts}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                        </tr>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shotsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowedP}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($secondsP!=0){{number_format(($allowedP*3600/$secondsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shotsP!=0){{number_format((($shotsP-$allowedP)*100/$shotsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$secondsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutoutsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                        </tr>
                                        <?php 
                                            $index=$stat->season;
                                            $games = 0;
                                            $shots = 0;
                                            $allowed = 0;
                                            $seconds = 0;
                                            $shutouts = 0;
                                            $goals = 0;
                                            $assists = 0;
                                            $penalties = 0;
                                            $gamesP = 0;
                                            $shotsP = 0;
                                            $allowedP = 0;
                                            $secondsP = 0;
                                            $shutoutsP = 0;
                                            $goalsP = 0;
                                            $assistsP = 0;
                                            $penaltiesP = 0;
                                            if($game->type==1)
                                            {
                                                $games = $stat->games;
                                                $shots = $stat->SOG;
                                                $allowed = $stat->GA;
                                                $seconds = $stat->seconds;
                                                $shutouts = $stat->shutouts;
                                                $goals = $stat->Goals;
                                                $assists = $stat->Assists;
                                                $penalties = $stat->PIM;
                                            }
                                            else
                                            {
                                                $gamesP += $stat->games;
                                                $shotsP += $stat->SOG;
                                                $allowedP += $stat->GA;
                                                $secondsP += $stat->seconds;
                                                $shutoutsP += $stat->shutouts;
                                                $assistsP += $stat->Assists;
                                                $goalsP += $stat->Goals;
                                                $penaltiesP += $stat->PIM;
                                            }
                                            $season = App\Season::where('id','=',$index)->first();
                                            $league = App\League::where('id','=',$season->league)->first();
                                        ?>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shots}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowed}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($seconds!=0){{number_format(($allowed*3600/$seconds), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shots!=0){{number_format((($shots-$allowed)*100/$shots), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$seconds}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutouts}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                        </tr>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shotsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowedP}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($secondsP!=0){{number_format(($allowedP*3600/$secondsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shotsP!=0){{number_format((($shotsP-$allowedP)*100/$shotsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$secondsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutoutsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                        </tr>
                                    @endif
                                    @if($index==$stat->season && $last->id!=$stat->id)
                                    <?php
                                        if($game->type==1)
                                        {
                                            $games = $stat->games;
                                            $shots = $stat->SOG;
                                            $allowed = $stat->GA;
                                            $seconds = $stat->seconds;
                                            $shutouts = $stat->shutouts;
                                            $goals = $stat->Goals;
                                            $assists = $stat->Assists;
                                            $penalties = $stat->PIM;
                                        }
                                        else
                                        {
                                            $gamesP += $stat->games;
                                            $shotsP += $stat->SOG;
                                            $allowedP += $stat->GA;
                                            $secondsP += $stat->seconds;
                                            $shutoutsP += $stat->shutouts;
                                            $assistsP += $stat->Assists;
                                            $goalsP += $stat->Goals;
                                            $penaltiesP += $stat->PIM;
                                        }
                                        $season = App\Season::where('id','=',$index)->first();
                                        $league = App\League::where('id','=',$season->league)->first();
                                    ?>
                                    @endif
                                    @if($last->id!=$stat->id && $index!=$stat->season)
                                        <?php 
                                            $season = App\Season::where('id','=',$index)->first();
                                            $league = App\League::where('id','=',$season->league)->first(); 
                                        ?>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.regular_season')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$games}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shots}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowed}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($seconds!=0){{number_format(($allowed*3600/$seconds), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shots!=0){{number_format((($shots-$allowed)*100/$shots), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$seconds}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutouts}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goals}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assists}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penalties}}</td>
                                        </tr>
                                        <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                                            <td style='border:solid; border-width:1px;'>{{$league->leagueName}} {{$season->seasonName}} {{__('messages.play-off')}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$gamesP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shotsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$allowedP}}</td>
                                            <td style='border:solid; border-width:1px;'>@if($secondsP!=0){{number_format(($allowedP*3600/$secondsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>@if($shotsP!=0){{number_format((($shotsP-$allowedP)*100/$shotsP), 2, '.', '')}} @else 0 @endif</td>
                                            <td style='border:solid; border-width:1px;'>{{$secondsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$shutoutsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$goalsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$assistsP}}</td>
                                            <td style='border:solid; border-width:1px;'>{{$penaltiesP}}</td>
                                        </tr>
                                        <?php 
                                            $index=$stat->season;
                                            $games = 0;
                                            $shots = 0;
                                            $allowed = 0;
                                            $seconds = 0;
                                            $shutouts = 0;
                                            $goals = 0;
                                            $assists = 0;
                                            $penalties = 0;
                                            $gamesP = 0;
                                            $shotsP = 0;
                                            $allowedP = 0;
                                            $secondsP = 0;
                                            $shutoutsP = 0;
                                            $goalsP = 0;
                                            $assistsP = 0;
                                            $penaltiesP = 0;
                                            if($game->type==1)
                                            {
                                                $games = $stat->games;
                                                $shots = $stat->SOG;
                                                $allowed = $stat->GA;
                                                $seconds = $stat->seconds;
                                                $shutouts = $stat->shutouts;
                                                $goals = $stat->Goals;
                                                $assists = $stat->Assists;
                                                $penalties = $stat->PIM;
                                            }
                                            else
                                            {
                                                $gamesP += $stat->games;
                                                $shotsP += $stat->SOG;
                                                $allowedP += $stat->GA;
                                                $secondsP += $stat->seconds;
                                                $shutoutsP += $stat->shutouts;
                                                $assistsP += $stat->Assists;
                                                $goalsP += $stat->Goals;
                                                $penaltiesP += $stat->PIM;
                                            }
                                        ?>
                                    @endif
                                @endforeach
                                </table>
                        @else 
                        {{__('messages.there_are_no_statistics_from_previous_seasons')}}
                        @endif
                    @endif  
                </p>
                @endif
                @if($set==0)
                <p>
                    {{__('messages.this_player_has_no_statistics')}}
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection