@extends('layouts.layout')


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

@section('body')
    <h1>{{$message}}</h1>
    <pre>
    @php
        if (isset($query)){
            print_r($query);
        }
        echo"<br>";
        // echo $query->section;
    @endphp

    </pre>
    <hr>
    <pre>
    @php
    
    if (isset($query)){
        $new = array();
        foreach ($query as $subquery) {
            if($subquery->position == "President"){
                array_push($new, $subquery);
            }
        }
    }
    print_r($new);
    @endphp
    
    </pre>
    <hr>
    <h1>{{session('level')}}</h1>
    <pre>
    @php
    $level = ['One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve'];
    $positions = array();
    foreach ($query as $subquery) {
        if (in_array($subquery->position, $level)){
            if($subquery->position != session('level')){
               continue;
            }
        }
        if (in_array($subquery->position, $positions)){
            continue;
        }
        array_push($positions,$subquery->position);
        }
    print_r($positions)
    @endphp
    </pre>
    <hr>
    <pre>
    @php
    $positionsClean = array();
    foreach ($positions as $subPosition) {
        $string = str_replace(" ","", $subPosition);
        $string = str_replace(".","", $string);
        array_push($positionsClean, $string);
    }
    print_r($positionsClean);
    @endphp
    </pre>
    <hr>
    <pre>
    @php
    foreach (array_combine($positionsClean, $positions) as $cleanPositions => $uncleanPositions) {
        // Create a dynamic variable instance
        ${$cleanPositions} = array();
        for ($i = 0; $i < sizeof($query); $i++) { 
            if ($query[$i]->position == $uncleanPositions) {
                array_push(${$cleanPositions}, $query[$i]);
            }
        }
    }

    foreach ($positionsClean as $subPositionsClean) {
        print_r(${$subPositionsClean});
    }
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
                                        @if (session('department') == "Elementary")
                                            @if (${$subPositionsClean}[0]->position == session('level'))
                                                Grade {{ ${$subPositionsClean}[0]->position}} Councilor
                                            @else
                                            {{ ${$subPositionsClean}[0]->position}}
                                            @endif
                                        @else
                                            @if (${$subPositionsClean}[0]->position == session('level'))
                                                Grade {{ ${$subPositionsClean}[0]->position}}
                                            @else
                                                {{ ${$subPositionsClean}[0]->position}}
                                            @endif
                                        @endif
                                    </h3>
                                    <hr>
                                </div>
                                @for ($i = 0; $i < sizeof(${$subPositionsClean}); $i++)
                                <div class="row">
                                    <div class="form-outline mb-2 col-12">
                                        <input type="radio" name="{{ ${$subPositionsClean}[$i]->position }}" value="{{ ${$subPositionsClean}[$i]->id }}" id="{{ ${$subPositionsClean}[$i]->id }}" />
                                        <label for="{{ ${$subPositionsClean}[$i]->id }}"> {{ ${$subPositionsClean}[$i]->firstname." ".${$subPositionsClean}[$i]->lastname }} </label>
                                    </div>
                                </div>
                                @endfor                           
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="row mt-2 row-cols-xxl-3 d-flex gap-xl-2 gap-xxl-2 justify-content-center min-vw-100  h-100">
                    <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4 col-xxl-3 mb-xxl-2 mb-2 mb-xxl-4">
                    <button class="btn btn-primary btn-lg btn-block w-100"
                            type="submit">
                        Vote
                    </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@endsection