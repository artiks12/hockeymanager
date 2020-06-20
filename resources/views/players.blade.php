@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">{{__('messages.filter')}}</div>

            <div class="card-body">
                {{ Form::open([ 'method' => 'get', 'action' => 'PlayerController@search'])}}
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
                {{ Form::submit(__('messages.search')) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{__('messages.players')}}</div>

            <div class="card-body">
                @if(count($players)>0)
                <table style='text-align:center;'>
                    <tr>
                        <td style='border:solid; border-width:1px; width:25px;'>#</td>
                        <td style='border:solid; border-width:1px; width:200px;'>{{__('messages.player')}}</td>
                        <td style='border:solid; border-width:1px; width:50px;'>{{__('messages.position')}}</td>
                        <td style='border:solid; border-width:1px; width:200px;'>{{__('messages.team')}}</td>
                        <td style='border:solid; border-width:1px; width:100px;'>{{__('messages.league')}}</td>
                        <td style='border:solid; border-width:1px;'>{{__('messages.number')}}</td>
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
                        <td style='border:solid; border-width:1px; width:50px;'>@if($player->position=='G') {{__('messages.goalie')}} @elseif($player->position=='D') {{__('messages.defenceman')}} @else {{__('messages.forward')}} @endif </td>
                        <td style='border:solid; border-width:1px; width:200px;'>@if($player->team!=NULL){{$team->teamName}} @else {{__('messages.free_agent')}} @endif</td>
                        <td style='border:solid; border-width:1px; width:100px;'>@if($player->team!=NULL){{$league->leagueName}} @endif</td>
                        <td style='border:solid; border-width:1px;'>@if($player->team!=NULL){{$player->number}} @endif</td>
                    </tr>

                    @endforeach
                </table>
                @else
                {{__('messages.there_are_no_players_that_match_our_records')}}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection