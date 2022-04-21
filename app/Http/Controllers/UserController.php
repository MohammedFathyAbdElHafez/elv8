<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::orderBy('id')->get()->all();

/*         foreach ($users as $user) {
            dd($user->roles()->pluck('name')[0]);
        } */
        $users = array_map(function ($user) {
            $user->role = $user->roles()->pluck('name')[0];
            return $user;
        }, $users);

        return view('user.index', compact('users'));
    }
}
