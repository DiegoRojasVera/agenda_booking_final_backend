<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puntuacion;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Service;


class PuntuacionController extends Controller
{
    public function store(Request $request)
    {
        $puntuacion = new Puntuacion();

        $puntuacion->calificacion = $request->calificacion;
        $puntuacion->stylist = $request->stylist;
        $puntuacion->comentario = $request->comentario;
        $puntuacion->nombre = $request->nombre;
        $puntuacion->photo = $request->photo;


        $puntuacion->save();

        return response()->json([
            'message' => 'Puntuación guardada correctamente'
        ]);
    }

    public function promedioPorStylist($stylist)
    {
        $promedio = DB::table('ratingbar')
            ->where('stylist', $stylist)
            ->avg('calificacion');

        return response()->json([
            'promedio' => $promedio
        ]);
    }

    public function index()
    {
        $puntuaciones = Puntuacion::all();

        return response()->json($puntuaciones);
    }

    public function listarPorStylist($stylist)
    {
        $puntuaciones = Puntuacion::where('stylist', $stylist)->get();
        return response()->json($puntuaciones);
    }
    //vamos a listar y saber si fue atenda por el stylis

    public function showStylistsAndServices($email)
    {
        $stylistsAndServices = Client::select('stylist', 'service', 'stylistName', 'email')
            ->where('email', $email)
            ->groupBy('stylist', 'service', 'stylistName', 'email')
            ->get();

        return response()->json($stylistsAndServices);
    }

    //saber el nombre del stylist que nos da con la id

    public function getServiceName($id)
    {
        $service = Service::find($id);
        return response()->json(['name' => $service->name]);
    }
}
