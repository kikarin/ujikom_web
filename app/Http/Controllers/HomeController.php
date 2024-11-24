<?php

namespace App\Http\Controllers;
use App\Models\Gallery;
use App\Models\Info;
use App\Models\Agenda;
use App\Models\Photo;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        $galleryItems = Gallery::with('photos')->latest()->take(4)->get();
        $infoItems = Info::latest()->take(4)->get();
        $agendaItems = Agenda::latest()->take(4)->get();
    
        return view('home.index', compact('galleryItems', 'infoItems', 'agendaItems','photos'));
    }
    
}
