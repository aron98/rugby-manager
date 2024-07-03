<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\TransferType;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = Transfer::all()->sortBy(function(Transfer $transfer){
            return $transfer->getEarliestBeginDate();
        });
        return view('transfers', [
            'transfers' => $transfers
        ]);
    }

    public function show($transferType) {
        $transfers = Transfer::all()->filter(function(Transfer $transfer) use($transferType){
            return $transferType == $transfer->transfer_type->name;
        })->sortBy(function(Transfer $transfer){
            return $transfer->getEarliestBeginDate();
        });
        return view('transfers', [
            'transfers' => $transfers
        ]);
    }
}
