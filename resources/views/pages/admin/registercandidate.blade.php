@extends('layouts.layout')

@section('title')
    {{ session('department')}}: Register candidate
@endsection

@section('style')
@endsection

@section('script')
function assess () {
    var department  = document.getElementById('department').value;
    var position = document.getElementById('position');
    var elementary = [
        "President",
        "Vice President",
        "Secretary",
        "Treasurer",
        "Auditor",
        "P.I.O",
        "P.O",
        "Grade One Councilor",
        "Grade Two Councilor",
        "Grade Three Councilor",
        "Grade Four Councilor",
        "Grade Five Councilor",
        "Grade Six Councilor"
    ];
    var junior = [
        "President",
        "Vice President",
        "Secretary",
        "Treasurer",
        "Auditor",
        "P.I.O",
        "P.O",
        "Grade Seven Chairperson",
        "Grade Seven Representative",
        "Grade Eight Chairperson",
        "Grade Eight Representative",
        "Grade Nine Chairperson",
        "Grade Nine Representative",
        "Grade Ten Chairperson",
        "Grade Ten Representative"
    ];
    var senior = [
        "President",
        "Vice President",
        "Secretary",
        "Treasurer",
        "Auditor",
        "P.I.O",
        "P.O",
        "Grade Eleven Chairperson",
        "Grade Eleven Representative",
        "Grade Twelve Chairperson",
        "Grade Twelve Representative"
    ];

    var child = position.lastElementChild;
    var x = position.options.length;
    while (child) {
        if(x===1){
            break;
        }
        position.removeChild(child);
        child = position.lastElementChild;
        x--;
    }

    if (department == "Elementary") {
        for (const val of elementary) {
            var option = document.createElement("option");
            option.value = val;
            option.text = val;
            position.appendChild(option);
        }
    } else if (department == "Junior") {
        for (const val of junior) {
            var option = document.createElement("option");
            option.value = val;
            option.text = val;
            position.appendChild(option);
        }
    } else if (department == "Senior") {
        for (const val of senior) {
            var option = document.createElement("option");
            option.value = val;
            option.text = val;
            position.appendChild(option);
        }
    }

    
}

function assessPassword () {
    var pass = document.getElementById('password');
    var confirmation = document.getElementById('confirmation');
    var message =  document.getElementById('message');
    if (pass.value != confirmation.value) {
        pass.style = "border:3px solid red";
        confirmation.style = "border:3px solid red";
        message.innerHTML = "Passwords do not match!";
    } else {
        message.innerHTML = "";
        confirmation.style = "border:3px solid green";
        pass.style = "border:3px solid green";
    }
}
function noString(str) {
    return /^[0-9]+$/.test(str);
  }
function assessId () {
    var idObj = document.getElementById('number');
    var idStr = idObj.value;
    if (!noString(idStr)) {
        idObj.style = "border:3px solid red";
    } else {
        idObj.style = "border:3px solid green";
    }
}
@endsection

@section('body')
<div class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <form action="{{ route('registercandidate') }}" method="POST">
            @csrf
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Register Candidate</h3>
                            <div class="row">
                                <div class="form-outline mb-4 col-12">
                                    <input type="text" id="firstname" name="firstname"
                                        class="form-control form-control-lg" placeholder="Firstname" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-outline mb-4 col-12">
                                    <input type="text" id="lastname" name="lastname"
                                        class="form-control form-control-lg" placeholder="Lastname" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-outline mb-4 col-12">
                                    <select name="department" id="department" onchange="assess();"
                                        class="form-control form-control-lg w-100" required>
                                        <option disabled selected>Department</option>
                                        <option value="Elementary">Elementary Department</option>
                                        <option value="Junior">Junior High School Department</option>
                                        <option value="Senior">Senior High School Department</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-outline mb-4 col-12">
                                    <select name="position" id="position" class="form-control form-control-lg w-100">
                                        <option disabled selected>Position</option>
                                    </select>
                                </div>
                            </div>



                            <button class="btn btn-primary btn-lg btn-block w-100" type="submit">Register Candidate</button>

                            <hr class="my-4">


                            <div class="row">
                            <a href="{{ route('login') }}">
                                <button class="btn btn-lg btn-block btn-primary w-100"
                                    style="background-color: #dd4b39;" type="button">Log In</button>
                            </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection