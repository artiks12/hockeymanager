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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function menu($id, $page = 'home')
    {
        if(Team::where('id','=',$id)->exists())
        {
            $info = Team::where('id','=',$id)->first();
            $games = Game::where('HostTeam','=',$id)->orWhere('VisitingTeam','=',$id)->get();
            $nextGame = $games->where('season','=',$info->season)->where('HomeScore','=',NULL)->sortBy('id')->first();
            if($nextGame->HostTeam==$info->id)
            {
                $opponent = Team::where('id','=',$nextGame->VisitingTeam)->first();
            }
            else
            {
                $opponent = Team::where('id','=',$nextGame->HostTeam)->first();
            }
            $players = Player::all();
            return view('myTeam',array('players' => $players, 'opponent' => $opponent, 'info' => $info, 'league' => 1, 'page' => $page, 'games' => $games, 'nextGame' => $nextGame));
        }
        else
        {
            return view('myTeam', array('league' => 0));
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
        return redirect('teams');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::where('id','=',$id)->first();
        return view('teamView',array('team' => $team));
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
