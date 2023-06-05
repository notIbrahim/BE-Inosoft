<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Vehicle;
use MongoDB\Client;
use App\Http\Controllers\DB;
class Motorcycles extends Vehicle
{
    public $Engine;
    public $SuspensionTypes;
    public $TranmissionTypes;

    // public function __construct(Request $request)
    // {
    //     parent::__construct();
    // }

    public function Stock(Request $requested) 
    {
        $FetchInfo = new DB;
        $Collection = $FetchInfo->SetConstruct("BE-Inosoft", "Sample-Inosoft", "mongodb://localhost:27017");
        // if ((bool)$Collection) {
        //     return response()->json("Connection Succesfull", 200);
        // }
    }
}
