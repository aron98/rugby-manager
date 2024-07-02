<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{$place->name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>{{$place->name}}</h1>
    <div class="row">
        <div class="col">
            <div class="container border" style="padding-bottom: 8px">
                <h2>Departures</h2>
                <div class="container">
                    <div class="row">
                        <div class="col">Transfer</div>
                        <div class="col">Time</div>
                        <div class="col">Team(s)</div>
                        <div class="col">Driver</div>
                        <div class="col">License plate</div>
                    </div>
                </div>
                @foreach($transferDaysFrom as $transferDay)
                    <div class="container">
                        <h3>{{$transferDay->first()->begin->toDateString()}}</h3>
                        @foreach($transferDay->sortBy('begin') as $tp)
                            <div class="row border">
                                <div class="col border">{{$tp->transfer()->first()->transfer_name}}</div>
                                <div class="col border">{{$tp->begin->toTimeString()}}</div>
                                <div class="col border">{{$tp->transferPartTeams()->get()->map(function($tpt){
                                return $tpt->team()->first()->name." (".$tpt->number_of_people.")";
                            })->join(", ")}}</div>
                                <div class="col border">{{$tp->transfer()->first()->driver}}</div>
                                <div class="col border">{{$tp->transfer()->first()->license_plate}}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col">
            <div class="container border" style="padding-bottom: 8px">
                <h2>Arrivals</h2>
                <div class="container">
                    <div class="row">
                        <div class="col">Transfer</div>
                        <div class="col">Time</div>
                        <div class="col">Team(s)</div>
                        <div class="col">Driver</div>
                        <div class="col">License plate</div>
                    </div>
                </div>
                @foreach($transferDaysTo as $transferDay)
                    <div class="container">
                        <h3>{{$transferDay->first()->begin->toDateString()}}</h3>
                        @foreach($transferDay->sortBy('end') as $tp)
                            <div class="row border">
                                <div class="col border">{{$tp->transfer()->first()->transfer_name}}</div>
                                <div class="col border">{{$tp->end->toTimeString()}}</div>
                                <div class="col border">{{$tp->transferPartTeams()->get()->map(function($tpt){
                                return $tpt->team()->first()->name." (".$tpt->number_of_people.")";
                            })->join(", ")}}</div>
                                <div class="col border">{{$tp->transfer()->first()->driver}}</div>
                                <div class="col border">{{$tp->transfer()->first()->license_plate}}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

</body>
</html>
