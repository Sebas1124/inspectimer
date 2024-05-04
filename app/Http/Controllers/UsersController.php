<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {

        $users = User::all();

        return view('users.Index', compact('users'));
    }

    public function store( Request $request ){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'gender' => 'required',
        ]);

        //validate the email if is a real email with regex
        $email = $request->email;
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['error' => 'Invalid email']);
        }

        $gender = $request["gender"];

        switch ($gender) {
            case 'man':
                $request['picture'] = asset('imgs/userMan.png');
                break;
            
            case 'woman':
                $request['picture'] = asset('imgs/userWoman.png');
                break;
            
            case 'other':
                $request['picture'] = asset('imgs/otro.png');
                break;

            default:
                $request['picture'] = asset('imgs/userMan.png');
                break;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender'    => $request->gender,
            'picture_path' => $request['picture']
        ]);


        return json_encode(['success' => 'User created']);
    }
    

}
