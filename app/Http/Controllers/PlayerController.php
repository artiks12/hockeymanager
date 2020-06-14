<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Team;
use App\Field;
use App\Goalie;
use App\League;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all()->sortBy('surname')->sortBy('name');
        return view('players', array('players' => $players));
    }
    public function search(Request $request)
    {
        $players = Player::all();
        if($request->Name!=NULL) {$players = Player::where('name','LIKE', '%'.$request->Name.'%')->get();}
        if($request->Surname!=NULL) {$players = Player::where('surname','LIKE', '%'.$request->Surname.'%')->get();}
        if($request->Position=='G'){$players = Player::where('position','=','G')->get();}
        elseif($request->Position=='D'){$players = Player::where('position','=','D')->get();}
        elseif($request->Position=='F'){$players = Player::where('position','=','F')->get();}
        $players = $players->sortBy('surname')->sortBy('name');
        return view('players', array('players' => $players));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $teams = Team::where('league','=',$id)->pluck('teamName','id');
        if(count($teams)>0)
        {
            return view('playerCreate', array('teams' => $teams, 'statuss' => 1));
        }
        return view('playerCreate', array('statuss' => 0));
    }
    
    public function sign($id,$player)
    {
        $player = Player::where('id','=',$player)->first();
        return view ('contracts',array('player' => $player));
    }
    
    public function get(Request $request, $id, $team)
    {
        $player = Player::where('id','=',$id)->first();
        $teammates = Player::where('team','=',$team)->get();
        $number = 0;
        foreach($teammates as $teammate)
        {
            if($teammate->number==$request->number && $teammate->id!=$id)
            {
                $number=$request->number;
                break;
            }
        }
        $rules = array(
            'number' => 'required|integer|gt:0|lt:100|not_in:'.$number,
            'money' => 'required|numeric|gte:0',
            'years' => 'required|integer|gt:0',
            );   
        $this->validate($request, $rules);
        $player->team = $team;
        $player->number = $request->number;
        $player->Years = $request->years;
        $player->Cap = ($request->money)/($request->years);
        $player->save();
        return redirect('/team='.$team.'/page=contracts');
    }
    
    public function release($id)
    {
        $player = Player::where('id','=',$id)->first();
        $team = $player->team;
        $player->team=NULL;
        $player->number=NULL;
        $player->Cap=NULL;
        $player->Years=NULL;
        $player->save();
        return redirect('/team='.$team.'/page=contracts');
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
            'Name' => 'required|alpha|min:2',
            'Surname' => 'required|alpha|min:2',
            'height' => 'gte:0',
            'weight' => 'gte:0',
        );   
        $this->validate($request, $rules);
        $player = new Player();
        $player->name = $request->Name;
        $player->surname = $request->Surname;
        if($request->date!=NULL){$player->birthday = $request->date;}
        if($request->height!=NULL){$player->height = $request->height;}
        if($request->weight!=NULL){$player->weight = $request->weight;}
        $player->position = $request->Position;
        if($user->role!=4){$player->team=$request->Team;}
        $player->save();
        $league = League::where('commisioner','=',$user->id)->first();
        return redirect('league='.$league->id.'/options');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player=Player::where('id','=',$id)->first();
        $team = Team::where('id','=',$player->team)->first();
        if($player->position!='G')
        {
            $stats = Field::where('player','=',$id)->cursor('id','desc');
            if(count($stats)>0)
            {
                $last = Field::where('player','=',$id)->orderBy('id','desc')->first();
                return view('playerView',array('set' => 1, 'point' => $last->season,'player' => $player, 'team' => $team, 'stats' => $stats));
            }
            else
            {
                return view('playerView',array('set' => 0, 'player' => $player, 'team' => $team));
            }
        }
        else
        {
            $stats = Goalie::where('player','=',$id)->cursor('id','desc');
            if(count($stats)>0)
            {
                $last = Goalie::where('player','=',$id)->orderBy('id','desc')->first();
                return view('playerView',array('set' => 1, 'point' => $last->season,'player' => $player, 'team' => $team, 'stats' => $stats));
            }
            else
            {
                return view('playerView',array('set' => 0, 'player' => $player, 'team' => $team));
            }
        }
    }
    public function byGame($id,$season)
    {
        $player=Player::where('id','=',$id)->first();
        $team = Team::where('id','=',$player->team)->first();
        if($player->position!='G')
        {
            $stats = Field::where('player','=',$id)->where('season','=',$season)->cursor('id','desc');
            return view('playerView',array('set' => 2,'player' => $player, 'team' => $team, 'stats' => $stats));
        }
        else
        {
            $stats = Goalie::where('player','=',$id)->cursor('id','desc');
            return view('playerView',array('set' => 2,'player' => $player, 'team' => $team, 'stats' => $stats));
        }
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
