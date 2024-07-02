<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('places', [
            'places' => Place::all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $place = Place::findOrFail($id);
        $transferPartsFrom = $place->transferPartsFrom()->get();
        $transferDaysFrom = collect();
        foreach($transferPartsFrom as $tp) {
            $date = $tp->begin->todateString();
            if (!$transferDaysFrom->has($date)) {
                $transferDaysFrom->put($date, collect());
            }
            $transferDaysFrom->get($date)->push($tp);
        }
        $transferPartsTo = $place->transferPartsTo()->get();
        $transferDaysTo = collect();
        foreach($transferPartsTo as $tp) {
            $date = $tp->end->todateString();
            if (!$transferDaysTo->has($date)) {
                $transferDaysTo->put($date, collect());
            }
            $transferDaysTo->get($date)->push($tp);
        }
        return view('place', [
            'place' => $place,
            'transferDaysFrom' =>$transferDaysFrom,
            'transferDaysTo' => $transferDaysTo
        ]);
    }
}
