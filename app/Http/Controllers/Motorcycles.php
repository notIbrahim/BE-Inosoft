<?php

declare (strict_types=1);
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Vehicle;
use MongoDB\Client;
use MongoDB\Exception\Exception as MongoException;
use App\Http\Controllers\DB;
use Error;
use Exception;
use Illuminate\Support\Facades\DB as MongoDB;
/** 
 * @param string $Engine 
 * @param string $SuspensionTypes Tipe Suspensi dalam Motor tersebut 
 * @param string $TranmissionTypes Tipe Transmisi  
 */

class Motorcycles extends Vehicle
{
    public $Engine;
    public $SuspensionTypes;
    public $TranmissionTypes;
    private $Collection;
    private $Database;

    public function __construct() {
        $this->Database = new DB("BE-Inosoft", "Sample-Inosoft", "mongodb://localhost:27017");
        $this->Collection = $this->Database->CallDatabase();
    }

    public function DataBulk(Request $request) {
        $ParamData = $request->all();
        $this->Engine =  $ParamData['Engine'] ?? null;
        $this->SuspensionTypes =  $ParamData['SuspensionTypes'] ??  null;
        $this->TranmissionTypes =  $ParamData['TranmissionTypes'] ?? null;
        $this->ReleaseModel =  $ParamData['ReleaseModel'] ?? null;
        $this->Colors =  $ParamData['Colors'] ?? null;
        $this->Price =  $ParamData['Price'] ??  null;
        $this->StockVehicle =  $ParamData['Stock'] ?? null;
    }

    public function Stock() 
    {
        $Options = [
            'Limit' => 25,
        ];
        $Filter = [
            'Engine' => $this->Engine
        ];

        $ReceivedCollection = $this->Collection;
        $result = $ReceivedCollection->find($Filter, $Options);
        if ($result == false || $result == null) 
        {
            return response()->json("Not Found Data", 404);
        }
        return $result;
    }

    public function AddStock()
    {
        $ReceivedCollection = $this->Collection;
        $Data = [
            'Engine' => $this->Engine,
            'Suspension Types' => $this->SuspensionTypes,
            'Tranmission Types' => $this->TranmissionTypes,
            'Release Model' => $this->ReleaseModel,
            'Colors' => $this->Colors,
            'Price' => $this->Price,
            'Stock' => $this->StockVehicle
        ];
        try {
            $result = $ReceivedCollection->insertOne($Data);
            if ($result == Null || $result == false) {
                return response()->json("Failed To Add Stock", 400);
            }
        } 
        catch (Exception $Error)
        {
            throw new Exception($Error->getMessage(), $Error->getCode());
        }
        return $result;
    }
    // I don't think best way to put this using delete but well anyway
    public function UpdateStock()
    {
        $ReceivedCollection = $this->Collection;
        $Filter = [
            'Engine' => $this->Engine,
            'Suspension Types' =>$this->SuspensionTypes,
            'Tranmission Types' =>$this->TranmissionTypes,
            'Release Model' => $this->ReleaseModel
        ];

        $Update = [
            '$set' => [
                'Suspension Types' => $this->SuspensionTypes,
                'Tranmission Types' => $this->TranmissionTypes,
                'Color' => $this->Colors,
                'Price' => $this->Price,
                'Stock' => $this->StockVehicle
            ]
        ];

        $Options = ['upsert' => true];
        try {
           $result =  $ReceivedCollection->findOneAndUpdate($Filter, $Update, $Options);
            if ($result == false && $result == null) {
                return response()->json('Failed to Update', 400);
            }
        } 
        catch (Exception $Error)
        {
            throw new Exception($Error->getMessage(), $Error->getCode());
        }
        return $result;
    }

    // Ini merupakan Penjualan dari Kendaran Motor
    public function Sales(Request $requested)
    {
        $ReceivedCollection = $this->Collection;
        $Filter = [
            'Engine' => $this->Engine,
            'Suspension Types' =>$this->SuspensionTypes,
            'Tranmission Types' =>$this->TranmissionTypes,
            'Release Model' => $this->ReleaseModel
        ];

        $Options = [
            'Limit' => 25,
        ];

        try {
           $result =  $ReceivedCollection->find($Filter, $Options);
            if ($result == false && $result == null) {
                return response()->json('Failed to Find', 400);
            }
        } 
        catch (Exception $Error)
        {
            throw new Exception($Error->getMessage(), $Error->getCode());
        }
        return $result;
    }

    public function EachSales(Request $requested) 
    {
        $Options = [
            'Limit' => 25,
        ];
        $ReceivedCollection = $this->Collection;
        $Filter = [
            'Engine' => $this->Engine,
            'Suspension Types' =>$this->SuspensionTypes,
            'Tranmission Types' =>$this->TranmissionTypes,
            'Release Model' => $this->ReleaseModel
        ];
        
        try {
           $result =  $ReceivedCollection->findOne($Filter, $Options);
            if ($result == false && $result == null) {
                return response()->json('Failed to Find', 400);
            }
        } 
        catch (Exception $Error)
        {
            throw new Exception($Error->getMessage(), $Error->getCode());
        }
        return $result;        
    }
}
