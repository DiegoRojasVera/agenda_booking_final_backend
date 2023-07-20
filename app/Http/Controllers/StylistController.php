<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Stylist;

class StylistController extends Controller
{
    public function index()
    {
        return response()->json(Stylist::orderBy('id', 'ASC')
            //  ->with('appointments.stylist', 'appointments.service')
            ->get());
    }

    //Register Stylist
    public function register(Request $request)
    {
        //validate fields

        $attrs = $request->validate([
            'name' => 'required|string',
            'photo' => 'string',
            'phone' => 'required|string',
            'score' => 'string',

        ]);

        //create user
        $stylist = Stylist::create([
            'name' => $attrs['name'],
            'photo' => $attrs['photo'],
            'phone' => $attrs['phone'],
            'score' => $attrs['score'],

        ]);

        return response([
            'message' => 'Stylist created.',
            'Stylist' => $stylist,
        ], 200);
    }

    // get single 
    public function show($id)
    {
        return response()
            ->json(Stylist::where('id', $id)
                //     ->with('appointments.stylist', 'appointments.service')
                //->orderByDesc('email', 'DESC')
                ->get());
    }

    //delete post
    public function destroy($id)
    {
        $stylist = Stylist::find($id);


        // $client->comments()->delete();
        // $client->likes()->delete();
        $stylist->delete();

        return response([
            'message' => 'stylist deleted.'
        ], 200);
    }
}
