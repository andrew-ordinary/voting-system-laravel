@extends('layouts/layout')

@section('title')
    @if (session('department') == 'Elementary')
        Vote: {{session('department')}} Department
    @else
        Vote: {{session('department')}} High School Department
    @endif
@endsection

@section('style')
* {
    box-sizing: border-box;
}

input[type="checkbox"],
input[type="radio"] {
    display: none;
    /* hide the default check boxes and radios */
}

/* style the label elements */
label {
    display: block;
    width: 100%;
    padding: 15px;
    border: 1px solid #0076ff;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.3), 0 7px 21px 0 rgba(0, 0, 0, 0.20);
}

/* create our custom checkbox and radio */
label>span {
    display: inline-block;
    width: 15px;
    height: 15px;
    border: 3px solid #0076ff;
    border-radius: 50%;
    margin-right: 30px;
}

/* style the labels when their corresponding inputs are checked */
input[type="checkbox"]:checked+label,
input[type="radio"]:checked+label {
    background: #173459;
    color: white;
}

/* style the custom check boxes and radios when their corresponding inputs are checked */
input[type="checkbox"]:checked+label>span,
input[type="radio"]:checked+label>span {
    background: #0076ff;
}

*{
	font-size: 20px;
	font-variant: small-caps;
	font-style: monospace;
}
@endsection
@php
// CREATE AN ARRAY TO RETRIEVE UNIQUE ELECTION POSITIONS AND RETRIEVE THE RESPECTIVE 
$auxillaryPositions = [
    'Grade One Councilor',
    'Grade Two Councilor',
    'Grade Three Councilor',
    'Grade Four Councilor',
    'Grade Five Councilor',
    'Grade Six Councilor',
    'Grade Seven Chairperson',
    'Grade Seven Representative',
    'Grade Eight Chairperson',
    'Grade Eight Representative',
    'Grade Nine Chairperson',
    'Grade Nine Representative',
    'Grade Ten Chairperson',
    'Grade Ten Representative',
    'Grade Eleven Chairperson',
    'Grade Eleven Representative',
    'Grade Twelve Chairperson',
    'Grade Twelve Representative'
];
$positions = array();
foreach ($query as $subquery) {
    if (in_array($subquery->position, $auxillaryPositions)){
        if(strpos($subquery->position, session('level')) === false){
           continue;
        }
    }
    if (in_array($subquery->position, $positions)){
        continue;
    }
    array_push($positions,$subquery->position);
    }

$positionsClean = array();
foreach ($positions as $subPosition) {
    $string = str_replace(" ","", $subPosition);
    $string = str_replace(".","", $string);
    array_push($positionsClean, $string);
}

foreach (array_combine($positionsClean, $positions) as $cleanPositions => $uncleanPositions) {
    // Create a dynamic variable instance
    ${$cleanPositions} = array();
    for ($i = 0; $i < sizeof($query); $i++) { 
        if ($query[$i]->position == $uncleanPositions) {
            array_push(${$cleanPositions}, $query[$i]);
        }
    }
}
session()->flash('positionsClean', $positionsClean);

@endphp

@section('body')
<pre>
@php
    print_r($query);

    print_r($positions);
    print_r(session()->all());
@endphp
</pre>


<nav class="px-5 py-3 sticky">
    <div class="container-fluid">
        <h3>Welcome To JFJFJ department fioejfjj</h3>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
</nav>
<div class="min-vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100 min-vw-100">
        <div class="row container-fluid">
            <div class="container-fluid py-auto px-5">
                <div class="d-flex justify-content-center text-center">
                    <h3>Welcome To JFJFJ department fioejfjj</h3>
                </div>
            </div>
        </div>
        <form action="/vote" method="POST">
            @csrf
            <div class="row row-cols-xxl-3 d-flex gap-xl-2 gap-xxl-2 justify-content-center min-vw-100 align-items-center h-100">
                @foreach ($positionsClean as $subPositionsClean)
                <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4 col-xxl-3 mb-xxl-2 mb-2 mb-xxl-4">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-3 text-center">
                            <div class="row mb-2">
                                <h3 class="mb-3">
                                    {{ ${$subPositionsClean}[0]->position }}
                                </h3>
                                <hr>
                            </div>
                            @for ($i = 0; $i < sizeof(${$subPositionsClean}); $i++) 
                            <div class="row">
                                <div class="form-outline mb-2 col-12">
                                    <input type="radio" name="{{ $subPositionsClean }}"
                                        value="{{ ${$subPositionsClean}[$i]->id }}"
                                        id="{{ ${$subPositionsClean}[$i]->id }}" />
                                    <label for="{{ ${$subPositionsClean}[$i]->id }}"> {{
                                        ${$subPositionsClean}[$i]->firstname." ".${$subPositionsClean}[$i]->lastname }}
                                    </label>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="row mt-2 row-cols-xxl-3 d-flex gap-xl-2 gap-xxl-2 justify-content-center min-vw-100  h-100">
                    <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4 col-xxl-3 mb-xxl-2 mb-2 mb-xxl-4">
                        <button class="btn btn-primary btn-lg btn-block w-100" type="submit">
                            Vote
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection