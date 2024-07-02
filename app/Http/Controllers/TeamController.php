<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teams', [
            'teams' => Team::all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = Team::findOrFail($id);
        $transferParts = $team->transferPartTeams()->get()->map(function($tpt){
            return $tpt->transferPart()->first();
        });
        $transferDays = collect();
        foreach($transferParts as $tp) {
            $date = $tp->begin->todateString();
            if (!$transferDays->has($date)) {
                $transferDays->put($date, collect());
            }
            $transferDays->get($date)->push($tp);
        }
        //dd($transferDays);
        return view('team', [
            'team' => $team,
            'transferDays' => $transferDays
        ]);
    }
}
