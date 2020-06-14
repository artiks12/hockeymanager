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
</style>
@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{$host->teamName}} vs {{$visit->teamName}}</div>
            <div class="card-body">
                <table class='log'>
                    <tr>
                        <td>Team</td>
                        <td>1st</td>
                        <td>2nd</td>
                        <td>3rd</td>
                        @if($overtime>=1)
                        <td>OT</td>
                        @endif
                        @if($overtime==2)
                        <td>Shootout</td>
                        @endif
                        <td>Total</td>
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
                <p><div class="btn btn-primary @if($page=='log') active @endif" style='width:33%;' onclick="location.href='{{url('games='.$game->id.'/log')}}'">Log</div>
                <div class="btn btn-primary @if($page=='stats') active @endif" style='width:33%;' onclick="location.href='{{url('games='.$game->id.'/stats')}}'"}}'>Stats</div>
                @if(!Auth::guest())
                <?php 
                    $user = Auth::user();
                ?>
                    @if($user->role==3)
                        <div class="btn btn-primary @if($page=='update') active @endif" style='width:33%;' onclick="location.href='{{url('games='.$game->id.'/update')}}'"}}'>Update</div>
                    @endif
                @endif
                </p>
            @if($page=='log')
            @if($events>0)
            <table class='log'>
                <tr>
                    <td>Time</td>
                    <td>Team</td>
                    <td>Event</td>
                    <td>Description</td>
                </tr>
                @if($events==3)
                @foreach($list as $note)
                <tr>
                    <?php 
                        $team = App\Team::where('id','=',$note->team)->first();
                    ?>
                    <td>{{intval(($note->second)/60)}}:{{($note->second)%60}}</td>
                    <td>{{$team->teamName}}</td>
                    @if($note->scorer)
                    <?php 
                        $scorer = App\Player::where('id','=',$note->scorer)->first(); 
                        if($note->assist_1!=NULL){$assist1 = App\Player::where('id','=',$note->assist_1)->first();}
                        if($note->assist_2!=NULL){$assist2 = App\Player::where('id','=',$note->assist_2)->first();}
                        if($note->goalie!=NULL){$goalie = App\Player::where('id','=',$note->goalie)->first();}
                    ?>
                    <td>Goal</td>
                    <td>Scorer: {{$scorer->name}} {{$scorer->surname}} @if($note->assist_1!=NULL)<br> Assisted: {{$assist1->name}} {{$assist1->surname}} @endif @if($note->assist_2!=NULL) and {{$assist2->name}} {{$assist2->surname}} @endif <br>Goalie: @if($note->goalie!=NULL) {{$goalie->name}} {{$goalie->surname}} @else Empty Net @endif</td>
                    @else
                    <?php 
                        $player = App\Player::where('id','=',$note->player)->first();
                    ?>
                    <td>Penalty</td>
                    <td>{{$player->name}} {{$player->surname}} gets {{$note->minutes}} minutes for {{$note->reason}}</td>
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
                    ?>
                    <td>{{intval(($goal->second)/60)}}:{{($goal->second)%60}}</td>
                    <td>{{$team->teamName}}</td>
                    <td>Goal</td>
                    <td>Scorer: {{$scorer->name}} {{$scorer->surname}} @if($goal->assist_1!=NULL)<br> Assisted: {{$assist1->name}} {{$assist1->surname}} @endif @if($goal->assist_2!=NULL) and {{$assist2->name}} {{$assist2->surname}} @endif <br>Goalie: @if($goal->goalie!=NULL) {{$goalie->name}} {{$goalie->surname}} @else Empty Net @endif</td>
                </tr>
                @endforeach
                @endif
                @if($events==1)
                @endif
            </table>
            @endif
            @endif
            @if($page=='stats')
                @if(count($homeField)+count($homeGoalie)>0)
                    <p><h4>Home Team</h4></p>
                    <table>
                    @if(count($homeGoalie)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Goalie</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>SOA</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>GA</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Time on ice</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Assists</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>PIM</td>
                        </tr>
                        @foreach($homeGoalie as $stat)
                            <?php 
                                $player = App\Player::where('id','=',$stat->player)->first();
                            ?>
                            <tr onclick="location.href='{{url('players='.$player->id)}}'">
                                <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                                <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->SOG}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->GA}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->seconds}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->Assists}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if(count($homeField)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Player</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Goals</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Assists</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Points</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Penalties in minutes</td>
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
                    <p><h4>Visiting Team</h4></p>
                    <table>
                    @if(count($visitGoalie)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Goalie</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>SOA</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>GA</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Time on ice</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Assists</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>PIM</td>
                        </tr>
                        @foreach($visitGoalie as $stat)
                            <?php 
                                $player = App\Player::where('id','=',$stat->player)->first();
                            ?>
                            <tr onclick="location.href='{{url('players='.$player->id)}}'">
                                <td style='border:solid; border-width:1px;'>{{$player->number}}</td>
                                <td style='border:solid; border-width:1px;'>{{$player->name}} {{$player->surname}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->SOG}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->GA}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->seconds}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->Assists}}</td>
                                <td style='border:solid; border-width:1px;'>{{$stat->PIM}}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if(count($visitField)>0)
                        <tr>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Number</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Player</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Goals</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Assists</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Points</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>+/-</td>
                            <td style='border:solid; border-width:1px; font-weight:bold;'>Penalties in minutes</td>
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
            <h4>Roster upload:</h4>
            {{ Form::open([ 'method' => 'post' , 'action' => ['GameController@roster', $game->id, $team->id]])}}
                    <table>
                        <tr><td><h5>Goaltenders:</h5></td><td></td></tr>
                        @foreach($roster as $player)
                        @if($player->position=='G')
                            <tr>
                                <td>{{ Form::label('goalies[]', $player->name.' '.$player->surname) }}</td>
                                <td>{{ Form::checkbox(('goalies[]'), $player->id) }}</td>
                            </tr>
                        @endif
                        @endforeach
                        
                        <tr><td><h5>Defencemen:</h5></td><td></td></tr>
                        @foreach($roster as $player)
                        @if($player->position=='D')
                            <tr>
                                <td>{{ Form::label('defencemen[]', $player->name.' '.$player->surname) }}</td>
                                <td>{{ Form::checkbox(('defencemen[]'), $player->id) }}</td>
                            </tr>
                        @endif
                        @endforeach
                        
                        <tr><td><h5>Forwards:</h5></td><td></td></tr>
                        @foreach($roster as $player)
                        @if($player->position=='F')
                            <tr>
                                <td>{{ Form::label('forwards[]', $player->name.' '.$player->surname) }}</td>
                                <td>{{ Form::checkbox(('forwards[]'), $player->id) }}</td>
                            </tr>
                        @endif
                        @endforeach
                    </table>
                {{ Form::submit('Add') }}
                {{ Form::close() }}
            @endif
            @if($page=='update')
            <p>
            <h4>Add Goal:</h4>
            {{ Form::open([ 'method' => 'post'])}}
                <table>
                    
                </table>
            {{ Form::submit('Add') }}
            {{ Form::close() }}
            <h4>Add Penalty:</h4>
            {{ Form::open([ 'method' => 'post'])}}
                <table>
                    
                </table>
            {{ Form::submit('Add') }}
            {{ Form::close() }}
            <h4>Insert Protocols:</h4>
            </p>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection