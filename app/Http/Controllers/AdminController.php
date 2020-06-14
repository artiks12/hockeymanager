<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\League;
use App\Team;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page)
    {
        $users = User::all();
        $teams = Team::where('manager','=',NULL);
        $leagues = League::where('commisioner','=',NULL);
        return view('admin',array('page' => $page, 'teams' => $teams, 'leagues' => $leagues, 'users' => $users));
    }
    public function user(Request $request)
    {
        $team = Team::where('manager','=',$request->user)->orWhere('statistician','=',$request->user)->first();
        $league = League::where('commisioner','=',$request->user)->first();
        if($league!=NULL)
        {
            $league->commisioner = NULL;
            $league->save();
        }
        if($team!=NULL)
        {
            if($team->manager==$request->user)
            {
                $team->manager = NULL;
                $team->save();
            }
            else
            {
                $team->statistician = NULL;
                $team->save();
            }
        }
        User::where('id','=',$request->user)->delete();
        return redirect ('admin/menu');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
