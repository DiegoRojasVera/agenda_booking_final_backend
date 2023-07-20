<?php

namespace App\Http\Controllers;

use App\Models\Service_stylist;
use App\Models\Stylist;
use Illuminate\Http\Request;


class ServiciosStylistController extends Controller
{
    public function index()
    {

        $service_stylist = Service_stylist::select("service_stylist.*")->get()->toArray();

        return response()->json($service_stylist);
        //  return response()->json(Service_stylist::orderBy('id', 'ASC')
        //      ->get());
    }

    //Register Stylist
    public function register(Request $request)
    {
        //validate fields

        $attrs = $request->validate([
            'service_id' => 'required|string',
            'stylist_id' => 'required|string',

        ]);

        //create user
        $servicestylist = Service_stylist::create([
            'service_id' => $attrs['service_id'],
            'stylist_id' => $attrs['stylist_id'],


        ]);

        return response([
            'message' => 'servicestylist created.',
            'Stylist' => $servicestylist,
        ], 200);
    }

    // get single 
    public function show($id)
    {
        return response()
            ->json(Service_stylist::where('id', $id)
                //     ->with('appointments.stylist', 'appointments.service')
                //->orderByDesc('email', 'DESC')
                ->get());
    }
    // get single 
    public function showServicesStylist($stylist_id)
    {
        return response()
            ->json(Service_stylist::where('stylist_id', $stylist_id)
                ->get());
    }

    //delete post
    public function destroy($id)
    {
        $stylist = Service_stylist::find($id);


        // $client->comments()->delete();
        // $client->likes()->delete();
        $stylist->delete();

        return response([
            'message' => 'stylist deleted.'
        ], 200);
    }
}
