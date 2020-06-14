@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Filter</div>

            <div class="card-body">
                {{ Form::open([ 'method' => 'get', 'action' => 'PlayerController@search'])}}
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
                            <td>{{ Form::label('Position', 'Position:') }}</td>
                            <td>{{ Form::select('Position', array('0' => 'all','G' => 'Goalies', 'D' => 'Defencemen', 'F' => 'Forwards'), old('Position'),['class' => 'form-control'.
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
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Players</div>

            <div class="card-body">
                @if(count($players)>0)
                <table style='text-align:center;'>
                    <tr>
                        <td style='border:solid; border-width:1px; width:25px;'>#</td>
                        <td style='border:solid; border-width:1px; width:200px;'>Player</td>
                        <td style='border:solid; border-width:1px; width:50px;'>Position</td>
                        <td style='border:solid; border-width:1px; width:200px;'>Team</td>
                        <td style='border:solid; border-width:1px; width:100px;'>League</td>
                        <td style='border:solid; border-width:1px;'>Number</td>
                    </tr>
                    @foreach($players as $player)
                    <?php 
                    if($player->team!=NULL)
                    {
                        $team=App\Team::where('id','=',$player->team)->first();
                        $league=App\League::where('id','=',$team->league)->first();
                    } 
                    ?>
                    <tr onclick="location.href='{{url('players='.$player->id)}}'" style="cursor:pointer;">
                        <td style='border:solid; border-width:1px; width:25px;'>{{$loop->index+1}}</td>
                        <td style='border:solid; border-width:1px; width:200px;'>{{$player->name}} {{$player->surname}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>@if($player->position=='G') Goalie @elseif($player->position=='D') Defenceman @else Forward @endif </td>
                        <td style='border:solid; border-width:1px; width:200px;'>@if($player->team!=NULL){{$team->teamName}} @else Free Agent @endif</td>
                        <td style='border:solid; border-width:1px; width:100px;'>@if($player->team!=NULL){{$league->leagueName}} @endif</td>
                        <td style='border:solid; border-width:1px;'>@if($player->team!=NULL){{$player->number}} @endif</td>
                    </tr>

                    @endforeach
                </table>
                @else
                There are no players
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
