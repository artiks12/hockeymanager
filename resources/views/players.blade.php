@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Filter</div>

            <div class="card-body">
                
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Players</div>

            <div class="card-body">
                @foreach($players as $player)
                <?php if($player->team!=NULL){$team=App\Team::where('id','=',$player->team)->first();} ?>
                <a href='{{url('players='.$player->id)}}'>{{$player->name}} {{$player->surname}} @if($player->position=='G') Goalie @elseif($player->position=='D') Defenceman @else Forward @endif @if($player->team!=NULL){{$team->teamName}} @endif </a><br>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
