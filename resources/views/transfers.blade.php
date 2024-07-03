<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Transfers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>Transfers</h1>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col">Transfer</div>
                <div class="col">Provider</div>
                <div class="col">Transfer date</div>
                <div class="col">Departure time</div>
                <div class="col">From</div>
                <div class="col">To</div>
                <div class="col">Arrival time</div>
                <div class="col">Team(s)</div>
                <div class="col">Driver</div>
                <div class="col">License plate</div>
            </div>
        </div>
    </div>
    @foreach($transfers as $transfer)
        <div class="container" style="margin-bottom: 8px">
            @foreach($transfer->transferParts()->get()->sortBy('begin') as $tp)
                <div class="row border">
                    <div class="col border">{{$transfer->transfer_name}}</div>
                    <div class="col border">{{$transfer->transfer_type->value}}</div>
                    <div class="col border">{{$tp->begin->toDateString()}}</div>
                    <div class="col border">{{$tp->begin->toTimeString()}}</div>
                    <div class="col border">{{$tp->from()->first()->name}}</div>
                    <div class="col border">{{$tp->to()->first()->name}}</div>
                    <div class="col border">{{$tp->end->toTimeString()}}</div>
                    <div class="col border">{{$tp->transferPartTeams()->get()->map(function($tpt){
                                return $tpt->team()->first()->name." (".$tpt->number_of_people.")";
                            })->join(", ")}}</div>
                    <div class="col border">{{$transfer->driver}}</div>
                    <div class="col border">{{$transfer->license_plate}}</div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

</body>
</html>
