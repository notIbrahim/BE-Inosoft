<?php

namespace App\Http\Controllers;
declare(strict_types=1);
use Illuminate\Http\Request;
use App\Http\Controllers\Vehicle;
use MongoDB\Client;
use App\Http\Controllers\DB;
use Exception;
use Illuminate\Support\Facades\DB as MongoDB;
class Cars extends Controller
{
    public $Engine;
    public $CapacityPassenger;
    public $CarTypes;
    private $Collection;
    private $Database;

    public function __construct() {
        $this->Database = new DB("BE-Inosoft", "Sample-Inosoft", "mongodb://localhost:27017");
        $this->Collection = $this->Database->CallDatabase();
    }

    public function Stock() 
    {
        $ReceivedCollection = $this->Collection;
        return $ReceivedCollection ? $ReceivedCollection->find() : Throw new Exception("Collection cannot be fetch",400);       
    }

    public function AddStock(array $Collections)
    {
        MSG_EOF;
    }
    // I don't think best way to put this using delete but well anyway
    public function ReduceStock($Context, )
    {

    }

    // Ini merupakan Penjualan dari Kendaran Motor
    public function Sales(Request $requested)
    {
        $ReceivedCollection = $this->Collection;
        $Post = $ReceivedCollection->insertOne([
            "Sales" => [
                'Engine Manufacture' => '',
                'Year Manufacture' => '',
                'SuspensionTypes' => '',
                'TransmissionTypes' => '',
                'Colors' =>'',
                'Price' => '',                
            ]
        ]);
        // return $Post->getInsertedCount() > 0 ? response()->json("Inserted Success", 201) : 
        // response()->json("Failed to Insert ", 400);
    }

    public function EachSales(Request $requested) 
    {
        
    }
}
