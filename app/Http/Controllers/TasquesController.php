<?php

namespace App\Http\Controllers;
use App\Http\Requests\IndexUserTask;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasquesController extends Controller
{
    public function index(IndexUserTask $request)
    {

        if(Auth::user()->isSuperAdmin() || Auth::user()->hasRole('TaskManager')){
            $tasks = map_collection(Task::orderBy('created_at', 'desc')->get());
        }else{
            $tasks= map_collection($request->user()->tasks);
         }
        // Agafa de la base de dades i ho passa a la vista
        $users = User::all();
        return view('tasques', compact('tasks','users'));

    }
}
