<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //Register user
    public function register(Request $request)
    {
        //validate fields

        $attrs = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'fechaN' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        //create user
        $user = User::create([
            'name' => $attrs['name'],
            'phone' => $attrs['phone'],
            'fechaN' => $attrs['fechaN'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        //return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }

    // login user
    public function login(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt login
        if (!Auth::attempt($attrs)) {
            return response([
                'message' => 'Error en usuario o contraseña.'
            ], 403);
        }

        //return user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }

    // logout user
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }

    // get user details
    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

    // update user

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'Actualizado'
            ], 403);
        }

        // if ($user->user_id != auth()->user()->id) {
        //     return response([
        //         'message' => 'Permission denied.'
        //     ], 403);
        // }

        //validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'image' => 'string',
            'fechaN' => 'nullable',
            'admin' => 'string',
            'tokenFB' => 'string',


        ]);

        $user->update([
            'name' =>  $attrs['name'],
            'phone' =>  $attrs['phone'],
            'image' =>  $attrs['image'],
            'fechaN' =>  $attrs['fechaN'],


        ]);

        // for now skip for post image

        return response([
            'message' => 'Se actualizaron los datos.',
            'user' => $user
        ], 200);
    }

    //ultama id

    public function lastId()
    {

        return response()->json(User::orderBy('id')

            ->get());
    }

    public function updateToken(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'Actualizado'
            ], 403);
        }



        //validate fields
        $attrs = $request->validate([

            'tokenFB' => 'string',

        ]);

        $user->update([

            'tokenFB' =>  $attrs['tokenFB'],

        ]);

        // for now skip for post image

        return response([
            'message' => 'User updated.',
            'user' => $user
        ], 200);
    }
}
