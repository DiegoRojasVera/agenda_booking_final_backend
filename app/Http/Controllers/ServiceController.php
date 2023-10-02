<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Stylist;
use App\Models\Service_stylist;


class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::orderBy('id', 'ASC')
            ->with('appointments.stylist')
            ->get());
    }

    // get single client
    public function show($id)
    {
        return response()
            ->json(Service::where('id', $id)
                ->with('appointments.stylist',)
                //       ->orderByDesc('email', 'DESC')
                ->get());
    }

    //delete post
    public function destroy($id)
    {
        $client = Service::find($id);
        // $client->comments()->delete();
        // $client->likes()->delete();
        $client->delete();

        return response([
            'message' => 'Client deleted.'
        ], 200);
    }
	
	 public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'service_id' => 'required|integer',
            'stylist_id' => 'required|integer',
            'nombre_servicio' => 'required|string',
        ]);

        // Crea un nuevo registro Service_stylist
        $serviceStylist = Service_stylist::create([
            'service_id' => $request->input('service_id'),
            'stylist_id' => $request->input('stylist_id'),
            'nombre_servicio' => $request->input('nombre_servicio'),
        ]);

        // Retorna una respuesta con el registro creado
        return response()->json([
            'message' => 'Service_stylist created successfully',
            'data' => $serviceStylist,
        ], 201);
    }



}
