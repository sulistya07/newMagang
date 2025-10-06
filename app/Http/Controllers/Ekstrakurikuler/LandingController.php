<?php

namespace App\Http\Controllers\Ekstrakurikuler;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler\Ekstrakurikuler;

class LandingController extends Controller
{
    public function index()
    {
        $ekskul = Ekstrakurikuler ::latest()->get();

        return view('landing', [
            'title' => 'Ekstrakurikuler Siswa SMKN 7 Batam' ,
            'ekskul' => $ekskul
        ]);
    }
}