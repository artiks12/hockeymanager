<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\User;
use App\League;
use App\Season;
use App\TeamStat;
use App\Team;
use App\Goalie;
use App\Field;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = League::all()->sortBy('leagueName');
        return view('leagues',array('leagues' => $leagues));
    }
    public function season($leagueId, $seasonId)
    {
        $info = League::where('id','=',$leagueId)->first();
        $season = Season::where('id','=',$seasonId)->first();
        $latest = Season::where('league','=',$leagueId)->orderBy('id','desc')->first();
        $stats = TeamStat::where('season','=',$season->id)->orderBy('points')->orderBy('goalDifference')->orderBy('victories')->get();
        $teams = Team::all();
        return view('seasonView',array('latest' => $latest,'info' => $info, 'league' => 2, 'season' => $season, 'stats' => $stats, 'teams' => $teams));
    }
    public function begin()
    {
        if(auth()->user())
        {
            $user = auth()->user();
            if(League::where('commisioner','=',$user->id)->exists()) 
            {
                $league = League::where('commisioner','=',$user->id)->first();
                return redirect('league='.$league->id);
            }
            else
            {
                return view('myLeague');
            }
        }
        else
        {
            return redirect('leagues');
        }
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function menu($id)
    {
        if(auth()->user())
        {
            $info = League::where('id','=',$id)->first();
            if(Season::where('league','=',$info->id)->exists())
            {
                $user = auth()->user();
                $season = Season::where('league','=',$info->id)->orderBy('id','desc')->first();
                $stats = TeamStat::where('season','=',$season->id)->orderBy('points')->orderBy('goalDifference')->orderBy('victories')->get();
                $teams = Team::all();
                $league = League::where('id','=',$id)->first();
                $latest = Season::where('league','=',$league->id)->orderBy('id','desc')->first();
                if($info->commisioner!=$user->id)
                {
                    $league = League::where('id','=',$id)->first();
                    $latest = Season::where('league','=',$league->id)->orderBy('id','desc')->first();
                    return redirect('/leagues='.$info->id.'/season='.$latest->id);
                } 
                return view('seasonView',array('latest' => $latest,'user' => $user, 'info' => $info, 'league' => 2, 'season' => $season, 'stats' => $stats, 'teams' => $teams));
            }
            return redirect('/league='.$id.'/options');
        }
        else
        {
            return redirect('leagues='.$id);
        }
    }
    public function add($id)
    {
        if(Team::whereNull('league')->exists())
        {
            $teams = Team::whereNull('league')->orderBy('teamName')->get();
            return view('addTeam', array('teams' => $teams, 'statuss' => 1));
        }
        return view('addTeam', array('statuss' => 0));
    }
    public function new($id)
    {
        if(Team::where('league','=',$id)->exists())
        {
            $teams = Team::where('league','=',$id)->orderBy('teamName')->get();
            return view('newSeason', array('teams' => $teams, 'statuss' => 1));
        }
        return view('newSeason', array('statuss' => 0));
    }
    public function seasonCreate(Request $request)
    {
        $user = auth()->user(); $id = $user->id;
        if($request->has('ch'))
        {
            $league = League::where('commisioner','=',$id)->first();
            $season = new Season(); $season->seasonName=$request->name; $season->league = $league->id;  $season->save();
            $seasonGet = Season::where('league','=',$league->id)->orderBy('id','desc')->first();    $seasonId = $seasonGet->id; $checks = $request->input('ch');
            foreach($checks as $check)
            {
                $team = Team::find($check); 
                $team->season = $seasonId; 
                $team->save();
            }
            $teams = Team::where('season','=',$seasonId)->get();
            foreach($teams as $team)
            {
                $stat = new TeamStat(); 
                $stat->team = $team->id;    
                $stat->season = $seasonId;
                $stat->victories = 0;
                $stat->defeats = 0;
                $stat->overtimes = 0;
                $stat->points = 0;
                $stat->scoredGoals = 0;
                $stat->goalsAgainst = 0;
                $stat->goalDifference = 0;
                $stat->save();
            }        
            return redirect('/league='.$league->id);
        }
        else { return redirect('/league='.$league->id.'/newSeason'); }
    }
    public function import(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $league = League::where('commisioner','=',$id)->first();
        if($request->has('ch'))
        {
            $checks = $request->input('ch');
            foreach($checks as $check)
            {
                $team = Team::find($check);
                $team->league = $league->id;
                $team->save();
            }
            return redirect('/league='.$league->id.'/options');
        }
        else
        {
            return redirect('league='.$league->id.'/addTeams');
        }
        
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
        $league= new League(); 
        $league->leagueName=$request->name; 
        $league->commisioner=$user['id'];
        $league->save();
        $temp = League::where('commisioner','=',$user->id)->first();
        return redirect('league='.$temp->id.'/options');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $league = League::where('id','=',$id)->first();
        $seasons = Season::where('league','=',$id)->get();
        return view('leagueView',array('league' => $league, 'seasons' => $seasons));
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
