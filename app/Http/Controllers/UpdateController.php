<?php
namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
public function index()
    {
        $updates = Update::all();

        return response()->json($updates, 200);
    }

}
