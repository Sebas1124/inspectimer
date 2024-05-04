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
        ])->assignRole('empleado');


        return json_encode(['success' => 'User created']);
    }

    public function edit ( $id ){

        $user = User::find($id);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'gender' => $user->gender
        ]);
    }

    public function update ( Request $request, $id ){

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$id,
            'password' => 'required',
            'gender'   => 'required',
        ]);

        //validate the email if is a real email with regex
        $email = $request->email;
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['error' => 'Invalid email']);
        }

        $gender = $request->gender;

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

        $user = User::find($id);

        $userLastPassword = $user->password;

        
        $user->name = $request->name;
        $user->email = $request->email;

        if ( $userLastPassword !== $request->password ) {
            $user->password = bcrypt($request->password);
        }

        $user->picture_path = $request['picture'];
        $user->gender = $request->gender;
        $user->assignRole('empleado');

        $user->save();

        return json_encode(['success' => 'User updated']);
    }

    public function destroy ( $id ){

        $user = User::find($id);

        $nameUser = $user->name;

        $user->delete();

        return redirect()->route('admin.users.index')->with("success", "Usuario $nameUser eliminado correctamente");
    }
    

}
