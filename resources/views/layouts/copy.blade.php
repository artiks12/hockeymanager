<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
                        <li><a class="nav-link" href="{{ url('leagues') }}">Leagues</a></li>
                        <li><a class="nav-link" href="{{ url('players') }}">Players</a></li>
                        <li><a class="nav-link" href="{{ url('teams') }}">Teams</a></li>                         
                        <li><a class="nav-link" href="{{ url('games') }}">Games</a></li>
                        @if ( !Auth::guest())
                            <?php 
                                $user = Auth::user();
                                $team = App\Team::where('manager','=',$user->id)->first();
                                $page = 'home';
                            ?>
                            @if($user->role==1)
                            <?php 
                                $league = App\League::where('commisioner','=',$user->id)->first();
                            ?>
                            <li><a class="nav-link" href="{{ action('LeagueController@menu',$league->id) }}">My League</a></li>
                            <li><a class="nav-link" href="{{ url('team='.$team->id.'/page='.$page) }}">My Team</a></li>
                            @endif
                            @if($user->role==2)
                            <li><a class="nav-link" href="{{ url('team='.$team->id.'/page='.$page) }}">My Team</a></li>
                            @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
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
                                        {{ __('Logout') }}
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
                                <div class="card-header"><h4>Today's Games</h4></div>
                                    <div class="card-body">
                                        <?php 
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
                                            $games = App\Game::where('date','>=',strtotime($datebegin))->where('date','<',strtotime($dateend))->get();
                                        ?>
                                        @if($games->count()>0)
                                        @foreach($games as $game)
                                        <?php 
                                            $season = App\Season::where('id','=',$game->season)->first();
                                            $leagues = App\League::where('id','=',$season->league)->first();
                                            $host = App\Team::where('id','=',$game->HostTeam)->first();
                                            $visit = App\Team::where('id','=',$game->VisitingTeam)->first();
                                        ?>
                                        <div class="game" style="display:inline-block; float:none; margin:0 auto;">
                                            <div class="card">
                                                <div class="card-header" style='@if($game->HomeScore!=NULL && $game->VisitorScore!=NULL)background-color:lime;@endif'>{{$leagues->leagueName}} {{$season->seasonName}}</div>
                                                <a href='livani.lv' class="card-body">
                                                    <div class="row">
                                                        <div class="col-team" id='HomeTeam'>
                                                            {{$host->teamName}}
                                                        </div>
                                                        <div class="col-score" id='VisitTeam'>
                                                            @if($game->HomeScore!=NULL) {{$game->HomeScore}} @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-team" id='HomeScore'>
                                                            {{$visit->teamName}}
                                                        </div>
                                                        <div class="col-score" id='VisitScore'>
                                                            @if($game->VisitorScore!=NULL) {{$game->VisitorScore}} @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        There are no games today.
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
