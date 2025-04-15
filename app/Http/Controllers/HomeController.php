<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $data = [];
        
        if ($user && $user->isAdmin()) {
            $data['todayAppointments'] = Appointment::whereDate('date', today())->count();
            $data['pendingAppointments'] = Appointment::where('status', 'nieuw')->count();
        }
        
        return view('home', $data);
    }
}
