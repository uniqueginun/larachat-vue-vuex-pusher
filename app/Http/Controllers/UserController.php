<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index() {
        $id = auth()->id();
        $users = User::where('id', '!=', $id)->get();
        return response()->json($users);
    }
}
