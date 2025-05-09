<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainers = User::where('role', 'trainer')->get();
        return view('trainers.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:users']);
        
        $password = Str::random(10); // Генерация пароля
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'trainer'
        ]);
        
        // Отправка email с паролем (используйте Laravel Mail)
        Mail::to($user->email)->send(new TrainerPasswordMail($password));
        
        return redirect()->route('trainers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
