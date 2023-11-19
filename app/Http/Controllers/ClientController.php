<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Stylist;
use Carbon\Carbon;

class ClientController extends Controller

{

    public function Prueba()
    {
        echo now();
        return now();
    }
    public function index()
    {
        return response()->json(Client::orderBy('inicio', 'DESC')
            ->get());
    }

	public function indexToday()
	{
   	 $today = Carbon::today()->toDateString();
  	  return response()->json(Client::whereDate('inicio', $today)
        ->orderBy('inicio', 'DESC')
        ->with('appointments.stylist', 'appointments.service')
        ->get());
	}



    public function showStylist($stylist)
    {
        return response()
            ->json(Client::where('stylist', $stylist)
                //    ->with('appointments.stylist', 'appointments.service')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }
    // get single client
    public function show($email)
    {
        return response()
            ->json(Client::where('email', $email)
                ->with('appointments.stylist', 'appointments.service')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }

    // get single client para ver servicio cada uno se busca por stylista
    public function showall($idservicio)
    {
        return response()
            ->json(Client::where('service', $idservicio)
                // ->with('appointments.stylist')
                ->orderBy('inicio', 'DESC')
                ->get());
    }

    // get single client para ver servicio cada uno
    public function showallID($id)
    {
        return response()
            ->json(Client::where('id', $id)
                //              ->with('appointments.stylist')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }
    // get single client para ver servicio cada uno
    public function showallIDPRueba($id)
    {
        return response()
            ->json(Client::where('id', $id)
                //              ->with('appointments.stylist')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }


    //delete post
    public function destroy($id)
    {
        $client = Client::find($id);


        // $client->comments()->delete();
        // $client->likes()->delete();
        $client->delete();

        return response([
            'message' => 'Client deleted.'
        ], 200);
    }
}
