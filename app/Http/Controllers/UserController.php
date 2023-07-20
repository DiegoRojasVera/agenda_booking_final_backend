<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Stylist;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::orderBy('name')
            ->orderBy('name')
            ->get());
    }

    // get single client
    public function show($id)
    {
        return response()
            ->json(User::where('id', $id)
                ->orderBy('name')
                ->get());
    }

    //delete post
    public function destroy($id)
    {
        $client = User::find($id);


        // $client->comments()->delete();
        // $client->likes()->delete();
        $client->delete();

        return response([
            'message' => 'Client deleted.'
        ], 200);
    }
}
