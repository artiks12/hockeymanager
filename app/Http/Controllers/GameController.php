<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Season;
use App\Team;
use App\Game;
use App\League;
use DateTime;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all()->sortBy('date');
        $leagues = League::all()->pluck('leagueName','id');
        $leagues->prepend('all');
        $teams = Team::all()->pluck('teamName','id');
        $teams->prepend('all');
        return view('games', array('teams' => $teams, 'games' => $games, 'leagues' => $leagues));
    }
    
    public function search(Request $request)
    {
        $games = Game::all()->sortBy('date');
        if($request->Team!=0) {$games = Game::where('HostTeam','=',$request->Team)->orWhere('VisitingTeam','=',$request->Team)->get();}  
        if($request->from!=NULL)
        {
            $date = $request->date;
            $datebegin = $date.' 06:00:00';
            $games = $games->where('date','>=',strtotime($datebegin));          
        }
        if($request->to!=NULL)
        {
            $dateend = date("$request->date 06:00:00",strtotime('+1 day'));
            $games = $games->where('date','<',strtotime($dateend));
        }
        if($request->League!=0) 
        {
            $games = $games->where('league','=',$request->League);
        }  
        if($request->Type!=0){$games = $games->where('type','=',$request->Type);}
        $leagues = League::all()->pluck('leagueName','id');
        $leagues->prepend('all');
        $teams = Team::all()->pluck('teamName','id');
        $teams->prepend('all');
        return view('games', array('teams' => $teams, 'games' => $games, 'leagues' => $leagues));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $season = Season::where('league','=',$id)->orderBy('id','desc')->first();
        $teams = Team::where('season','=',$season->id)->pluck('teamName','id');
        return view('gameCreate', array('season' => $season, 'teams' => $teams, 'league' =>  $id));
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
            'date' => 'required|after:tomorrow',
            'time' => 'required',
            'HomeTeam' => 'required|different:VisitingTeam',
            'VisitingTeam' => 'required|different:HomeTeam'
        );   
        $this->validate($request, $rules);
        $combinedDT = date('Y-m-d H:i:s', strtotime("$request->date $request->time"));
        $game= new Game(); 
        $league = League::where('commisioner','=',$user->id)->orderBy('id','desc')->first();
        $season = Season::where('league','=',$league->id)->orderBy('id','desc')->first();
        $game->season = $season->id;
        $game->HostTeam = $request->HomeTeam;
        $game->type = $request->Type;
        $game->VisitingTeam = $request->VisitingTeam;
        $game->date = $combinedDT;
        $game->league = $league->id;
        $game->save();
        return redirect('leagues');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
