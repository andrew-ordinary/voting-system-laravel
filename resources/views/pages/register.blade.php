@extends('layouts.layout')

@section('title')
    Register
@endsection

@section('style')
@endsection

@section('script')

function myFunction(){
    window.alert('myfunction');
}
function assess () {
    var department  = document.getElementById('department').value;
    var level = document.getElementById('level');
    var elementary = ["One", "Two", "Three", "Four", "Five", "Six"];
    var junior = ["Seven", "Eight", "Nine", "Ten"];
    var senior = ["Eleven", "Twelve"];
    var child = level.lastElementChild;
    var x = level.options.length;
    while (child) {
        if(x===1){
            break;
        }
        level.removeChild(child);
        child = level.lastElementChild;
        x--;
    }

    if (department == "Elementary") {
        for (const val of elementary) {
            var option = document.createElement("option");
            option.value = val;
            option.text = val;
            level.appendChild(option);
        }
    } else if (department == "Junior") {
        for (const val of junior) {
            var option = document.createElement("option");
            option.value = val;
            option.text = val;
            level.appendChild(option);
        }
    } else if (department == "Senior") {
        for (const val of senior) {
            var option = document.createElement("option");
            option.value = val;
            option.text = val;
            level.appendChild(option);
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
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-3 text-center">

                            <h3 class="mb-5">Register</h3>
                            <div class="row">
                                <div class="form-outline mb-4 col-6">
                                    <input type="text" id="firstname" name="firstname"
                                        class="form-control form-control-lg" placeholder="Firstname" />
                                </div>

                                <div class="form-outline mb-4 col-6">
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
                                <div class="form-outline mb-4 col-6">
                                    <select name="level" id="level" class="form-control form-control-lg w-100">
                                        <option disabled selected>Level</option>
                                    </select>
                                </div>

                                <div class="form-outline mb-4 col-6">
                                    <input type="text" id="section" name="section" class="form-control form-control-lg"
                                        placeholder="Section" />

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-outline mb-2 col-12">
                                    <input type="number" id="number" onkeyup="assessId();" name="number"
                                        class="form-control form-control-lg w-100" placeholder="I.D. Number" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 text-center text-danger fs-4 font-sans-serif" id="message">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-outline mb-4 col-6">
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" placeholder="Enter Password" />
                                </div>

                                <div class="form-outline mb-4 col-6">
                                    <input type="password" id="confirmation" name="confirmation"
                                        onkeyup="assessPassword();" class="form-control form-control-lg"
                                        placeholder="Re-enter Password" />

                                </div>
                            </div>



                            <button class="btn btn-primary btn-lg btn-block w-100" type="submit">Register</button>

                            <hr class="my-4">


                            <div class="row mb-3">
                            <a href="{{ route('login') }}">
                                <button class="btn btn-lg btn-block btn-primary w-100"
                                    style="background-color: #dd4b39;" type="button">Log In</button>
                            </a>
                            </div>
                            <div class="row">
                            <a href="{{ route('adminlogin') }}">
                                <button class="btn btn-lg btn-block btn-primary w-100"
                                    style="background-color: #dd4b39;" type="button">Admin Log In</button>
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