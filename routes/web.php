<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    if (!session('logged')) {
        return redirect('/login');
    }
    return view('welcome');
});

Route::get('/login', function () {
    return view('pages.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $number = $request->input('number');
    $password = $request->input('password');
    $department = $request->input('department');
    $query = DB::connection($department)
        ->select('SELECT * FROM voters WHERE number = ?', [$number]);
    if (sizeof($query) == 0) {
        return "ZERO";
    }
    if (sizeof($query) != 1) {
        return "TODO";
    }
    $query = $query[0];

    if (!password_verify($password, $query->hash)) {
        // INCORRECT PASSWORD
        return "INCORRECT PASSWORD";
    }
    session([
        'logged'     => true,
        'id'         => $query->id,
        'firstname'  => $query->firstname,
        'lastname'   => $query->lastname,
        'department' => $query->department,
        'level'      => $query->level,
        'voted'      => $query->voted
    ]);
    return redirect()->route('vote'); //view('debug', ['message' => "ddw", 'query'   => $query]);
});

Route::get('/register', function () {
    return view('pages.register');
})->name('register');


// POST REGISTER
Route::post('/register', function (Request $request) {
    $firstname = $request->input('firstname');
    $lastname = $request->input('lastname');
    $department = $request->input('department');
    $level = $request->input('level');
    $section = $request->input('section');
    $number = $request->input('number');
    $password = $request->input('password');
    $confirmation = $request->input('confirmation');

    // Create password hash
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = DB::connection($department)
        ->insert('INSERT INTO voters (firstname, lastname, department, level, section, number, hash) 
        VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$firstname, $lastname, $department, $level, $section, $number, $hash]
        );


    if (!$query) {
        redirect()->back();
    } else {
        $queryTwo = (array) DB::connection($department)
            ->select('SELECT id, voted FROM voters WHERE number = ? AND hash = ?', [$number, $hash])[0];
    }
    session([
        'logged'     => true,
        'id'         => $queryTwo['id'],
        'firstname'  => $firstname,
        'lastname'   => $lastname,
        'department' => $department,
        'level'      => $level,
        'voted'      => $queryTwo['voted']
    ]);

    return redirect('/vote');
})->name('register');

Route::get('/vote', function () {
    if (session('voted') == 1) {
        return "ALREADY VOTED";
    }
    $query = DB::connection(session('department'))
        ->select("SELECT * FROM candidates");
    return view('pages.vote', ['message' => "kdkdkdkkd", 'query'   => $query]);
})->name('vote');

Route::post('/vote', function (Request $request) {
    $positionsClean = session('positionsClean');
    $voterId = session('id');
    foreach ($positionsClean as $subpositionsClean) {
        $candidateId = $request->input($subpositionsClean);
        $query = DB::connection(session('department'))
            ->insert('INSERT INTO votes (voter_id, candidate_id) VALUES (?,?)', [$voterId, $candidateId]);
        if (!$query) {
            return "FAILED";
        }
    }
    DB::connection(session('department'))
        ->update('UPDATE voters SET voted = 1 WHERE id = ?', [$voterId]);
    session(['voted' => 1]);
    return view('debugg', ['value' => $positionsClean]);
});

Route::get('/debugg', function (Request $request) {
    $positionsClean = session('positionsClean');
    return view('debugg', ['value' => $positionsClean]);
});


Route::get('/logout', function () {
    session()->forget([
        'logged',
        'id',
        'firstname',
        'lastname',
        'department',
        'level',
        'voted'
    ]);
    return redirect('/');
})->name('logout');


Route::get('/admin/registercandidate', function () {
    return view('pages.admin.registercandidate');
})->name('registercandidate');

Route::post('/admin/registercandidate', function (Request $request) {
    $firstname = $request->input('firstname');
    $lastname = $request->input('lastname');
    $position = $request->input('position');
    if (session('department')) {
        $department = session('department');
    } else {
        $department = $request->input('department');
    }
    $query = DB::connection($department)
        ->insert('INSERT INTO candidates (firstname, lastname, position) VALUES (?, ?, ?)', [$firstname, $lastname, $position]);
    if (!$query) {
        return "FAIL SQL";
    }
    return "REGISTERED";
});

Route::get('/admin', function () {
    if (!session('admin')) {
        return redirect()->route('adminlogin');
    }
    return view('pages.index');
})->name('admin');

// ADMIN LOGIN AUTH
Route::get('/admin/login', function () {
    return view('pages.admin.login');
})->name('adminlogin');


Route::post('/admin/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $department = $request->input('department');
    $query = DB::connection($department)
        ->select('SELECT * FROM admins WHERE username = ?', [$username]);
    if (sizeof($query) != 1) {
        return "SQL FAILED";
    } else {
        $query = $query[0];
    }
    if (!password_verify($password, $query->hash)) {
        return "PASSWORD WRONG";
    }
    session([
        'department' => $department,
        'admin'      => 1
    ]);

    return redirect()->route('admin');
});


// ADMIN REGISTER
Route::get('/admin/register', function () {
    return view('pages.admin.register');
})->name('adminregister');


Route::post('/admin/register', function (Request $request) {
    $firstname = $request->input('firstname');
    $lastname = $request->input('firstname');
    $authkey = $request->input('authkey');
    $username = $request->input('username');
    $password = $request->input('password');
    $department = $request->input('department');
    if ($authkey != "DuWDc8V5EY4SLh6") {
        return redirect()->back()->with('errormsg', "Incorrect Authentication Key");
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = DB::connection($department)
        ->insert('INSERT INTO admins (firstname, lastname, department, username, hash)
            VALUES (?, ?, ?, ?, ?)',
            [$firstname, $lastname, $department, $username, $hash]
        );
    if (!$query) {
        return redirect()->back()->with('errormsg', 'Error Creating Admin Account Try Again Later');
    }
    return view('pages.admin.register');
});





Route::get('/admin/logout', function () {
    session()->forget([
        'admin',
        'department'
    ]);
})->name('adminlogout');