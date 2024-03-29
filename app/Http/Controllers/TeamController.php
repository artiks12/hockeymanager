<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\League;
use App\Game;
use App\Player;
use App\Field;
use App\Goalie;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all()->sortBy('teamName');
        return view('teams',array('teams' => $teams));
    }
    public function begin()
    {
        if(auth()->user())
        {
            $user = auth()->user();
            if(Team::where('manager','=',$user->id)->exists()) 
            {
                $team = Team::where('manager','=',$user->id)->first();
                return redirect('team='.$team->id.'/page=home');
            }
            else
            {
                return view('myTeam', array('league' => 0));
            }
        }
        else
        {
            return redirect('teams');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function menu($id, $page = 'home')
    {
        $user = auth()->user();
        if($user)
        {
            $info = Team::where('id','=',$id)->first();
            if($info->manager==$user->id)
            {
                $games = Game::where('HostTeam','=',$id)->orWhere('VisitingTeam','=',$id)->get();
                $games = $games->where('HomeScore','=',NULL)->where('VisitorScore','=',NULL);
                $players = Player::all();
                if(count($games)>0)
                {
                    $nextGame = $games->where('season','=',$info->season)->sortBy('id')->first();
                    if($nextGame->HostTeam==$info->id)
                    {
                        $opponent = Team::where('id','=',$nextGame->VisitingTeam)->first();
                    }
                    else
                    {
                        $opponent = Team::where('id','=',$nextGame->HostTeam)->first();
                    }
                    return view('myTeam',array('players' => $players, 'opponent' => $opponent, 'info' => $info, 'league' => 1, 'page' => $page, 'games' => $games, 'nextGame' => $nextGame));
                }
                return view('myTeam',array('nextGame' => NULL,'players' => $players, 'info' => $info, 'league' => 1, 'page' => $page, 'games' => $games));
            }
            else
            {
                return redirect('teams='.$id.'/page=roster');
            }
        }
        else
        {
            return redirect('teams='.$id.'/page=roster');
        }
    }
    public function search(Request $request)
    {
        $teams = Team::all()->sortBy('teamName');
        if($request->Team!=NULL) {$teams = Team::where('teamName','LIKE', '%'.$request->Team.'%')->get();}
        return view('teams', array('teams' => $teams));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $rules = array(
            'name' => 'required|min:2'
        );   
        $this->validate($request, $rules);
        $team= new Team(); 
        $team->teamName=$request->name; 
        $team->manager=$user['id'];
        if($user['role']==1 && League::where('commisioner','=',$user->id)->exists())
        {
            $league=League::where('commisioner','=',$user->id)->first();
            $team->league=$league->id;
        }
        $team->save();
        $temp = Team::where('manager','=',$user->id)->first();
        return redirect('team='.$temp->id.'/page=home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statistician(Request $request, $id)
    {
        $team = Team::where('id','=',$id)->first();
        $team->statistician = $request->statistician;
        $team->save();
        return redirect('team='.$id.'/page=home');
    }
    public function show($id,$page)
    {
        $team = Team::where('id','=',$id)->first();
        $players = Player::where('team','=',$id)->get();
        $field = Field::all();
        $goalie = Goalie::all();
        return view('teamView',array('info' => $team, 'players' => $players, 'field' => $field, 'goalie' => $goalie, 'page' => $page));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
