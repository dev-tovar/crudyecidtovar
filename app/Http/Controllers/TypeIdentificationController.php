<?php

namespace App\Http\Controllers;

use App\Models\TypeIdentification;
use Illuminate\Http\Request;

class TypeIdentificationController extends Controller
{
    public function getTypeIdentifications(Request $request){
        if ($request->ajax()) {

            return TypeIdentification::get();

        } else {
            return response()->json(['message' => 'Forbidden request'], 403);
        }

    }
}
