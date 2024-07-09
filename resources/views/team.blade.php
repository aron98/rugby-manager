<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{$team->name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>{{$team->name}}</h1>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col">Transfer</div>
                <div class="col">Departure time</div>
                <div class="col">From</div>
                <div class="col">To</div>
                <div class="col">Arrival time</div>
                <div class="col">Driver</div>
                <div class="col">License plate</div>
                <div class="col">Driver phone</div>
            </div>
        </div>
    </div>
    @foreach($transferDays as $transferDay)
        <div class="container">
            <h3>{{$transferDay->first()->begin->toDateString()}}</h3>
            @foreach($transferDay->sortBy('begin') as $tp)
                <div class="row border">
                    <div class="col border">{{$tp->transfer()->first()->transfer_name}}</div>
                    <div class="col border">{{$tp->begin->toTimeString()}}</div>
                    <div class="col border">{{$tp->from()->first()->name}}</div>
                    <div class="col border">{{$tp->to()->first()->name}}</div>
                    <div class="col border">{{$tp->end->toTimeString()}}</div>
                    <div class="col border">{{$tp->transfer()->first()->driver}}</div>
                    <div class="col border">{{$tp->transfer()->first()->license_plate}}</div>
                    <div class="col border">{{$tp->transfer()->first()->phone_number}}</div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

</body>
</html>
