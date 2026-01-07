<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

$users = [
    [
        'id'    => 1,
        'name'  => 'John Doe',
        'age'   => 30
    ],
    [
        'id'    => 2,
        'name'  => 'Jane Doe',
        'age'   => 25
    ],
    [
        'id'    => 3,
        'name'  => 'John Doe',
        'age'   => 30
    ]
];

//for testing
Route::get('/users', function () use ($users): array {
    return $users;
});

Route::post('/users', function (Request $request) use ($users) {
    $newUser = [
        'id' => count($users) + 1,
        'name' => $request->input('name'),
        'age' => $request->input('age'),
    ];

    return response()->json($newUser, 201);
});

Route::get('/users/{id}', function ($id) use ($users) {
    if (!isset($users[$id - 1])) {
        abort(404);
    }

    return $users[$id - 1];
});


Route::put('/users/{id}', function (Request $request, $id) use ($users) {
    if (!isset($users[$id - 1])) {
        abort(404);
    }

    $updatedUser = [
        'id' => $id,
        'name' => $request->input('name'),
        'age' => $request->input('age'),
    ];

    return response()->json($updatedUser, 200);
});


Route::delete('/users/{id}', function ($id) use ($users) {
    if (!isset($users[$id - 1])) {
        abort(404);
    }

    return response()->json(['message' => 'Deleted'], 204);
});


//test view
Route::get('/test', function () {
    $title = 'test';
    $content = 'test content';
    return view('test', compact('title', 'content'));
});




Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register');

//test vaildation
Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});


Route::post('/login', [App\Http\Controllers\RegisterController::class, 'login'])->name('login');

Route::get('/logout', [App\Http\Controllers\RegisterController::class, 'logout'])->name('logout');
