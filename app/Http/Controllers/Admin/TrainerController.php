<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainerCredentialsMail;
use Illuminate\Support\Str; 

class TrainerController extends Controller
{
    // Показать форму создания
    public function create()
    {
        return view('trainers.create');
    }

    // Сохранить нового тренера
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'city' => 'required|string|max:255',
            'school' => 'required|string|max:255'
        ]);

        $password = Str::random(10);

        $trainer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'city' => $validated['city'],
            'school' => $validated['school'],
            'password' => bcrypt($password),
            'role' => 'trainer'
        ]);

        Mail::to($trainer->email)->send(new TrainerCredentialsMail($password));

        return redirect()->route('trainers.index')->with('success', 'Тренер успешно добавлен');
    }

    // Список всех тренеров
    public function index()
    {
        $trainers = User::where('role', 'trainer')->get();
        return view('trainers.index', compact('trainers'));
    }
}