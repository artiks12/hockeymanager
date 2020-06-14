@extends('layouts.copy')

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Filter</div>

            <div class="card-body">
                {{ Form::open([ 'method' => 'get', 'action' => 'TeamController@search'])}}
                    <table>
                        <tr>
                            <td>{{ Form::label('Team', 'Team:') }}</td>
                            <td>{{ Form::text('Team', '',['class' => 'form-control'.
                            ($errors-> has('Team') ? ' is-invalid' : '' )]) }}
                            @if ($errors-> has('Team'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('Team') }}</strong>
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
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                <?php
                    $leagues = App\League::all();
                ?>
                <?php $count=0 ?>
                @foreach($teams as $team)
                @if($team->league==NULL)
                @if($count==0)
                <h4>Teams with no league</h4>
                <ul>
                <?php $count++; ?>
                @endif
                    <li><a href='{{url('teams='.$team->id.'/page=roster')}}'>{{$team->teamName}}</a></li>
                @endif
                @endforeach
                @if($count!=0)
                </ul>
                @endif
                @foreach($leagues as $league)
                    <?php $count=0 ?>
                    @foreach($teams as $team)
                    @if($team->league==$league->id)
                        @if($count==0)
                        <h4>{{$league->leagueName}}</h4>
                        <ul>
                        <?php $count++; ?>
                        @endif
                        <li><a href='{{url('teams='.$team->id.'/page=roster')}}'>{{$team->teamName}}</a></li>
                    @endif
                    @endforeach
                    @if($count!=0)
                    </ul>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
