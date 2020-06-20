@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="leagueName" style="display:inline;">{{$info->leagueName}} {{$season->seasonName}}</div>
                @if(!Auth::guest())
                    <?php 
                        $user = Auth::user();
                    ?>
                    @if($info->commisioner==$user->id && $latest->id == $season->id)
                    <div class="makeSeason" style="float:right; display:inline;"><a href="{{action('SeasonController@options',$info->id)}}">{{__('messages.options')}}</a></div>
                    @endif
                @endif
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">{{__('messages.team_statistics')}}</div>
            <div class="card-body">
                <table>
                    <tr>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>#</td>
                        <td style='border:solid; border-width:1px; width:150px; text-align:center;'>Team</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>G</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>W</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>L</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>T</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>Pts</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>GD</td>
                    </tr>
                @foreach($stats as $stat)
                    <tr>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$loop->index+1}}</td>
                        <td style='border:solid; border-width:1px; width:150px; text-align:center;'>{{$teams[$stat->team-1]['teamName']}}</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$stat['victories']+$stat['defeats']+$stat['overtimes']}}</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$stat['victories']}}</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$stat['defeats']}}</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$stat['overtimes']}}</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$stat['points']}}</td>
                        <td style='border:solid; border-width:1px; width:20px; text-align:center;'>{{$stat['goalDifference']}}</td>
                    </tr>
                @endforeach
                </table>
                G - {{__('messages.games')}}, W - {{__('messages.wins')}}, L - {{__('messages.loses')}}, T - {{__('messages.overtimes')}}, Pts - {{__('messages.points')}}, GD - {{__('messages.goal_difference')}}
            </div>
        </div>
    </div>
</div>
@endsection


