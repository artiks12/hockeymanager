<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js', env('REDIRECT_HTTPS')) }}" defer></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
    <style>
    a.card-body
    {
        margin:0 auto;
        text-decoration:none;
        color:black;
    }
    a.card-body:hover
    {
        text-decoration:none;
        color:black;
    }
    div.col-team
    {
        width:100px;
    }
    div.col-score
    {
        width:30px;
        text-align:center;
    }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li><a class="nav-link" href="{{ url('leagues') }}">{{__('messages.leagues')}}</a></li>
                        <li><a class="nav-link" href="{{ url('players') }}">{{__('messages.players')}}</a></li>
                        <li><a class="nav-link" href="{{ url('teams') }}">{{__('messages.teams')}}</a></li>                         
                        <li><a class="nav-link" href="{{ url('games') }}">{{__('messages.games')}}</a></li>
                        @if ( !Auth::guest())
                            <?php 
                                $user = Auth::user();
                            ?>
                            @if($user->role==1)
                            <li><a class="nav-link" href="{{ url('league') }}">{{__('messages.my_league')}}</a></li>
                            <li><a class="nav-link" href="{{ url('team') }}">{{__('messages.my_team')}}</a></li>
                            @endif
                            @if($user->role==2)
                            <li><a class="nav-link" href="{{ url('team') }}">{{__('messages.my_team')}}</a></li>
                            @endif
                            @if($user->role==3)
                            <?php 
                                $team = App\Team::where('statistician','=',$user->id)->first();
                            ?>
                            @if($team)
                            <?php 
                                $game = App\Game::where('VisitingTeam','=',$team->id)->orWhere('HostTeam','=',$team->id)->get();
                                $game = $game->where('HomeScore','=',NULL)->where('VisitorScore','=',NULL)->first();
                            ?>
                            @if($game)
                            <li><a class="nav-link" href='{{url('games='.$game->id.'/update')}}'>{{__('messages.next_game')}}</a></li>
                            @endif
                            @endif
                            @endif 
                            @if($user->role==4)
                            <li><a class="nav-link" href="/admin/menu">{{__('messages.admin')}}</a></li>
                            @endif 
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{__('messages.languages')}} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="lang/en">
                                    {{__('messages.english')}}
                                </a>
                                <a class="dropdown-item" href="lang/lv">
                                    {{__('messages.latvian')}}
                                </a>
                            </div>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('messages.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class='games'>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header"><h4>{{__('messages.today_games')}}</h4></div>
                                    <div class="card-body">
                                        <?php 
                                            date_default_timezone_set('Europe/Riga');
                                            $date = date('H:i:s');
                                            if(strtotime($date)<strtotime('06:00:00'))
                                            {
                                                $datebegin = date('Y-m-d 06:00:00',strtotime('-1 day'));
                                                $dateend = date('Y-m-d 06:00:00');
                                            }
                                            else
                                            {
                                                $datebegin = date('Y-m-d 06:00:00');
                                                $dateend = date('Y-m-d 06:00:00',strtotime('+1 day'));
                                            }
                                            $games = App\Game::all();
                                            $date = date('Y-m-d H:i:s');
                                            $counter = 0;
                                        ?>
                                        @if($games->count()>0)
                                        @foreach($games as $game)
                                        @if(strtotime($game->date)>=strtotime($datebegin) && strtotime($game->date)< strtotime($dateend))
                                        <?php 
                                            $season = App\Season::where('id','=',$game->season)->first();
                                            $leagues = App\League::where('id','=',$season->league)->first();
                                            $host = App\Team::where('id','=',$game->HostTeam)->first();
                                            $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                                            if($counter==0) $counter++;
                                        ?>
                                        <div class="game" style="display:inline-block; float:none; margin:0 auto;">
                                            <div class="card">
                                                <div class="card-header" style='@if($game->HomeScore!=NULL || $game->VisitorScore!=NULL)background-color:lime; @elseif(strtotime($game->date)<strtotime($date)) background-color:red;@endif'>{{$leagues->leagueName}} {{$season->seasonName}}<br> {{$game->date}}</div>
                                                <a href='{{url('games='.$game->id.'/log')}}' class="card-body">
                                                    <div class="row">
                                                        <div class="col-team" id='HomeTeam'>
                                                            {{$host->teamName}}
                                                        </div>
                                                        <div class="col-score" id='HomeScore'>
                                                            @if($game->HomeScore!=NULL) {{$game->HomeScore}} 
                                                            @elseif(strtotime($game->date)< strtotime($date))
                                                            <?php 
                                                                $goals=0;
                                                                $log = App\Goal::where('game','=',$game->id);
                                                                foreach($log as $goal)
                                                                {
                                                                    if($goal->team==$game->HostTeam) $goals++;
                                                                }
                                                            ?>
                                                            {{$goals}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-team" id='VisitTeam'>
                                                            {{$visit->teamName}}
                                                        </div>
                                                        <div class="col-score" id='VisitScore'>
                                                            @if($game->VisitorScore!=NULL) {{$game->VisitorScore}}
                                                            @elseif(strtotime($game->date)< strtotime($date))
                                                            <?php 
                                                                $goals=0;
                                                                $log = App\Goal::where('game','=',$game->id);
                                                                foreach($log as $goal)
                                                                {
                                                                    if($goal->team==$game-VisitingTeam) $goals++;
                                                                }
                                                            ?>
                                                            {{$goals}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if($counter==0)
                                        {{__('messages.no_games')}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
