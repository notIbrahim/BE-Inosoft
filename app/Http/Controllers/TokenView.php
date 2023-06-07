<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenView extends Controller
{
    public function index(Request $request)
    {
        if ($request->get("Message")  == "OK")
        {
            return response()->json([
                "Message" => "OK"
            ]);
        }
        return response()->json([
            'Message' => "Use This Token in Postman at Authorization Select Bearer Token",
            'Token' => $request->get('Token'),
        ], 200);
    }
}
