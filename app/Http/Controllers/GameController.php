<?php

namespace App;
namespace App\Http\Controllers;
use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        return view('game.index');
    }
}
