<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Stylist;

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
}
