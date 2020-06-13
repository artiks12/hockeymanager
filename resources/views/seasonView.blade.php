<?php 
    $user = Auth::user()->toArray();
    $id = $user['id'];
    $checkS = App\Season::where('league','=',$info->id)->orderBy('id','desc')->first();
?>
@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="leagueName" style="display:inline;">{{$info->leagueName}} {{$season->seasonName}}</div>
                @if($info->commisioner==$id && $season->id == $checkS->id)
                <div class="makeSeason" style="float:right; display:inline;"><a href="{{action('SeasonController@options',$id)}}">Options</a></div>
                @endif
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Team Statistics</div>
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
                G - games, W - wins, L - loses, T - overtimes, Pts - points, GD - goal diference
            </div>
        </div>
    </div>
</div>
@endsection


