<?php

namespace App\Http\Controllers;

use am5;
use App\Mail\Contact;
use Illuminate\Http\Request;
use App\Models\AutorisationAbsence;
use Illuminate\Support\Facades\Mail;

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
        $autorisationsAbsence = AutorisationAbsence::where('status', 'validated')->get();

        $data = [];
        foreach ($autorisationsAbsence as $autorisation) {
            $data[] = [
                "category" => $autorisation->personnel->nom,
                "fromDate" => $autorisation->date_debut,
                "toDate" => $autorisation->date_fin,

            ];
        }
        // Passer les données à la vue
        return view('home', [
            'data' => json_encode($data),
            'aa' => $data
        ]);
    }
}
