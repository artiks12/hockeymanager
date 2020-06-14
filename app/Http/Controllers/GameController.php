<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Season;
use App\Team;
use App\Game;
use App\League;
use App\Penalty;
use App\Goal;
use App\Goalie;
use App\Field;
use App\Player;

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
        $date = date('Y-m-d');
        $leagues = League::all()->pluck('leagueName','id');
        $leagues->prepend('all');
        $teams = Team::all()->pluck('teamName','id');
        $teams->prepend('all');
        return view('games', array('teams' => $teams, 'games' => $games, 'leagues' => $leagues, 'date' => $date));
    }
    
    public function search(Request $request)
    {
        $games = Game::all()->sortBy('date');
        $date = date('Y-m-d');
        if($request->Team!=0) {$games = Game::where('HostTeam','=',$request->Team)->orWhere('VisitingTeam','=',$request->Team)->get();}  
        if($request->date!=NULL){$date = $request->date;}
        if($request->League!=0) 
        {
            $games = $games->where('league','=',$request->League);
        }  
        if($request->Type!=0){$games = $games->where('type','=',$request->Type);}
        $leagues = League::all()->pluck('leagueName','id');
        $leagues->prepend('all');
        $teams = Team::all()->pluck('teamName','id');
        $teams->prepend('all');
        return view('games', array('teams' => $teams, 'games' => $games, 'leagues' => $leagues, 'date' => $date));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $season = Season::where('league','=',$id)->orderBy('id','desc')->first();
        if($season!=NULL)
        {
            $teams = Team::where('season','=',$season->id)->pluck('teamName','id');
            return view('gameCreate', array('season' => $season, 'teams' => $teams, 'league' =>  $id, 'statuss' => 1));
        }
        return view('gameCreate', array('season' => $season, 'league' =>  $id, 'statuss' => 0));
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
    public function roster(Request $request, $game, $team)
    {
        $goalies = $request->input('goalies');
        if($request->has('goalies') && $request->has('defencemen') && $request->has('forwards'))
        {
            $goalies = $request->input('goalies');
            $defencemen = $request->input('defencemen');
            $forwards = $request->input('forwards');
            if(count($goalies)==2 && count($defencemen)==6 && count($forwards)==12)
            {
                $temp = Game::where('id','=',$game)->first();
                $season = Season::where('id','=',$temp->season)->first();
                foreach($goalies as $goalie)
                {
                    $stat = new Goalie();
                    $stat->player=$goalie;
                    $stat->season = $season->id;
                    $stat->team = $team;
                    $stat->game = $game;
                    $stat->games = 0;
                    $stat->wins = 0;
                    $stat->loses = 0;
                    $stat->SOG = 0;
                    $stat->GA = 0;
                    $stat->seconds = 0;
                    $stat->shutouts = 0;
                    $stat->Goals = 0;
                    $stat->Assists = 0;
                    $stat->PIM = 0;
                    $stat->save();
                }
                foreach($defencemen as $defenceman)
                {
                    $stat = new Field();
                    $stat->player=$defenceman;
                    $stat->season = $season->id;
                    $stat->team = $team;
                    $stat->game = $game;
                    $stat->games = 0;
                    $stat->goals = 0;
                    $stat->assists = 0;
                    $stat->PIM = 0;
                    $stat->plus_minus = 0;
                    $stat->faceoffs = 0;
                    $stat->faceoffsWon = 0;
                    $stat->shots = 0;
                    $stat->blockedShots = 0;
                    $stat->save();
                }
                foreach($forwards as $forward)
                {
                    $stat = new Field();
                    $stat->player=$forward;
                    $stat->season = $season->id;
                    $stat->team = $team;
                    $stat->game = $game;
                    $stat->games = 0;
                    $stat->goals = 0;
                    $stat->assists = 0;
                    $stat->PIM = 0;
                    $stat->plus_minus = 0;
                    $stat->faceoffs = 0;
                    $stat->faceoffsWon = 0;
                    $stat->shots = 0;
                    $stat->blockedShots = 0;
                    $stat->save();
                }
                return redirect('/games='.$game.'/stats');
            }
            return redirect('/games='.$game.'/roster');
        }
        else { return redirect('/games='.$game.'/roster'); }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$page)
    {
        $game = Game::where('id','=',$id)->first();
        $host = Team::where('id','=',$game->HostTeam)->first();
        $visit = Team::where('id','=',$game->VisitingTeam)->first();
        $homeField = Field::where('game','=',$game->id)->where('team','=',$game->HostTeam)->get();
        $homeGoalie = Goalie::where('game','=',$game->id)->where('team','=',$game->HostTeam)->get();
        $visitField = Field::where('game','=',$game->id)->where('team','=',$game->VisitingTeam)->get();
        $visitGoalie = Goalie::where('game','=',$game->id)->where('team','=',$game->VisitingTeam)->get();
        $goals = Goal::where('game','=',$game->id)->orderBy('second','desc')->get();
        $penalties = Penalty::where('game','=',$game->id)->orderBy('second','desc')->get();
        $overtime = 0;
        foreach($goals as $goal)
        {
            if($goal->second==3900)
            {
                $overtime = 2;
                break;
            } 
            elseif($goal->second>3600)
            {
                $overtime = 1;
                break;
            }
        }
        $HostGoals = array(0,0,0,0,0);
        $VisitGoals = array(0,0,0,0,0);
        foreach($goals as $goal)
        {
            if($goal->team == $host->id)
            {
                if($goal->second==3900){$HostGoals[4]++;}
                elseif($goal->second>3600){$HostGoals[3]++;}
                elseif($goal->second>2400){$HostGoals[2]++;}
                elseif($goal->second>1200){$HostGoals[1]++;}
                else {$HostGoals[0]++;}
            }
            else
            {
                if($goal->second==3900){$VisitGoals[4]++;}
                elseif($goal->second>3600){$VisitGoals[3]++;}
                elseif($goal->second>2400){$VisitGoals[2]++;}
                elseif($goal->second>1200){$VisitGoals[1]++;}
                else {$VisitGoals[0]++;}
            }
        }
        if($page=='roster')
        {
            $user = auth()->user();
            $team = Team::where('manager','=',$user->id)->first();
            $roster = Player::where('team','=',$team->id)->get();
            return view('gameView',array('team' => $team,'roster' => $roster,'events' => 0 ,'hostGoals' => $HostGoals,'visitGoals' => $VisitGoals,'overtime' => $overtime,'game' => $game,'host' => $host,'visit' => $visit,'page' => $page,'goals' => $goals,'penalties' => $penalties));
        }
        if(count($goals)>0  && count($penalties)>0)
        {
            $countEvents = count($goals)+count($penalties);
            $counterG = 0;
            $counterP = 0;
            $goal = array();
            $penalty = array();
            foreach($penalties as $temp){array_push($penalty,$temp->id);}
            foreach($goals as $temp){array_push($goal,$temp->id);}
            $events = array();
            $tempG = Goal::where('id','=',$goal[$counterG])->first();
            $tempP = Penalty::where('id','=',$penalty[$counterP])->first();
            for($x=0; $x<$countEvents; $x++)
            {
                if($counterP!=count($penalties))
                    {
                        if($tempP->second>=$tempG->second || $counterG==count($goals))
                        {
                            array_push($events,$tempP);
                            if($counterP!=count($penalties))
                            {
                                $counterP++;
                                if($counterP!=count($penalties)){$tempP = Penalty::where('id','=',$penalty[$counterP])->first();}
                            }
                        }
                        else
                        {
                            array_push($events,$tempG);
                            if($counterG!=count($goals))
                            {
                                $counterG++;
                                if($counterG!=count($goals)){$tempG = Goal::where('id','=',$goal[$counterG])->first();}
                            }
                        }
                    }
                elseif($counterG!=count($goals))
                    {
                        if($tempG->second>$tempP->second || $counterP==count($penalties))
                        {
                            array_push($events,$tempG);
                            if($counterG!=count($goals))
                            {
                                $counterG++;
                                if($counterG!=count($goals)){$tempG = Goal::where('id','=',$goal[$counterG])->first();}
                            }
                        }
                        else
                        {
                            array_push($events,$tempP);
                            if($counterP!=count($penalties))
                            {
                                $counterP++;
                                if($counterP!=count($penalties)){$tempP = Penalty::where('id','=',$penalty[$counterP])->first();}
                            }
                        }
                    }
                
            }
            return view('gameView',array('visitGoalie' => $visitGoalie,'homeGoalie' => $homeGoalie,'visitField' => $visitField,'homeField' => $homeField,'list' => $events,'events' => 3 ,'hostGoals' => $HostGoals,'visitGoals' => $VisitGoals,'overtime' => $overtime,'game' => $game,'host' => $host,'visit' => $visit,'page' => $page,'goals' => $goals,'penalties' => $penalties));
        }
        elseif(count($goals)>0)
        {
            return view('gameView',array('visitGoalie' => $visitGoalie,'homeGoalie' => $homeGoalie,'visitField' => $visitField,'homeField' => $homeField,'events' => 2 ,'hostGoals' => $HostGoals,'visitGoals' => $VisitGoals,'overtime' => $overtime,'game' => $game,'host' => $host,'visit' => $visit,'page' => $page,'goals' => $goals,'penalties' => $penalties));
        }
        elseif(count($penalties)>0)
        {
            return view('gameView',array('visitGoalie' => $visitGoalie,'homeGoalie' => $homeGoalie,'visitField' => $visitField,'homeField' => $homeField,'events' => 1 ,'hostGoals' => $HostGoals,'visitGoals' => $VisitGoals,'overtime' => $overtime,'game' => $game,'host' => $host,'visit' => $visit,'page' => $page,'goals' => $goals,'penalties' => $penalties));
        }
        return view('gameView',array('visitGoalie' => $visitGoalie,'homeGoalie' => $homeGoalie,'visitField' => $visitField,'homeField' => $homeField,'events' => 0 ,'hostGoals' => $HostGoals,'visitGoals' => $VisitGoals,'overtime' => $overtime,'game' => $game,'host' => $host,'visit' => $visit,'page' => $page,'goals' => $goals,'penalties' => $penalties));
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
