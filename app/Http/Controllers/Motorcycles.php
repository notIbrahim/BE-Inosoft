<?php

declare (strict_types=1);
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Vehicle;
use MongoDB\Client;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB as MongoDB;

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
        $FetchInfo = new DB("BE-Inosoft", "Sample-Inosoft", "mongodb://localhost:27017");
        $Collection = $FetchInfo->CallDatabase();
        if ((bool)$Collection) {
            continue;
            // return response()->json("Connection Succesfull", 200);
        }        
    }

    // Ini merupakan Penjualan dari Kendaran Motor
    public function Sales (Request $requested)
    {
        $FetchInfo = new DB("BE-Inosoft", "Sample-Inosoft", "mongodb://localhost:27017");
        $Collection = $FetchInfo->CallDatabase();
        $Post = $Collection->insertOne([
            "Sales" => [
                'Engine Manufacture' => '',
                'Year Manufacture' => '',
                'SuspensionTypes' => '',
                'TransmissionTypes' => '',
                'Colors' =>'',
                'Price' => '',                
            ]
        ]);
        return $Post->getInsertedCount() > 0 ? response()->json("Inserted Success", 201) : 
        response()->json("Failed to Insert ", 400);
    }

    public function EachSales(Request $requested) 
    {

    }
}
