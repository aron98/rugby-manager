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
        })->filter(function($transferPart){
            return $transferPart != null &&
                $transferPart->transfer()->first() != null;
        });
        $transferDays = collect();
        foreach($transferParts as $tp) {
            $date = $tp->begin->todateString();
            if (!$transferDays->has($date)) {
                $transferDays->put($date, collect());
            }
            $transferDays->get($date)->push($tp);
        }
        $transferDays = $transferDays->sortBy(function($transferDay, $key){
            return $key;
        });
        return view('team', [
            'team' => $team,
            'transferDays' => $transferDays
        ]);
    }
}
