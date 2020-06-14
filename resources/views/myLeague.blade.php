@extends('layouts.copy')

<style>
    div.games
    {
        display:none;
    }
</style>
<?php 
    $user = Auth::user()->toArray();
    $id = $user['id'];
?>

@section('content')
<div class="row justify-content-center" style='margin-top:30px;'>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">League Maker</div>

            <div class="card-body">
                <?php 
                    $user = Auth::user()->toArray();
                    $id = $user['id'];
                ?>
                {{ Form::open([ 'method' => 'post' , 'action' => 'LeagueController@store'])}}
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
