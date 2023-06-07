<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Motorcycles;
use App\Http\Controllers\Cars;
class Vehicle extends Controller
{
    public $ReleaseModel;
    public $Colors;
    public $Price;
    protected $CarsService;
    protected $MotorcycleService;

    public function __construct(Cars $FunctionCarsService, Motorcycles $FunctionMotorcycleService) {
        $this->CarsService = $FunctionCarsService;
        $this->MotorcycleService = $FunctionMotorcycleService;
    }
    public function Motorcycles(Request $request) 
    {
        $MethodReceived = $request->method();
        $ParamCheck = $request->route('Specified');
        switch (strtoupper($MethodReceived)) {
            case "GET" :
            {
                // Optimal Solution are Loop but hindering by $this->MotorcycleService
                if ($ParamCheck == "Stock") {
                    $StockMotorcycles = $this->MotorcycleService->Stock();
                    return response()->json($StockMotorcycles, 302);
                }

                if ($ParamCheck == "Sales") {
                    $SalesMotorcycles = $this->MotorcycleService->Sales($request);
                    return response()->json($SalesMotorcycles, 302);
                }

                if ($ParamCheck == "EachSales") {
                    $EachSalesMotorcycles = $this->MotorcycleService->EachSales($request);
                    return response()->json($EachSalesMotorcycles, 302);
                }
            }
            case "POST":
            {
                if ($ParamCheck == "AddStock") {
                    $StockMotorcycles = $this->MotorcycleService->AddStock($request);
                    return response()->json($StockMotorcycles, 302);
                }
            }

            case "PUT":
            {

            }

            case "DELETE":
            {

            }
        }
        return response()->json([
            "Param" => $request->route('Specified'), 
            "Query" => $request->query('Query'), 
            $MethodReceived], 200);
    }

    public function Cars(Request $request) 
    {
        $MethodReceived = $request->method();
        $ParamCheck = $request->route('Specified');
        switch (strtoupper($MethodReceived)) {
            case "GET" :
            {
                // Optimal Solution are Loop but hindering by $this->MotorcycleService
                if ($ParamCheck == "Stock") {
                    $StockMotorcycles = $this->MotorcycleService->Stock();
                    return response()->json($StockMotorcycles, 302);
                }

                if ($ParamCheck == "Sales") {
                    $SalesMotorcycles = $this->MotorcycleService->Sales($request);
                    return response()->json($SalesMotorcycles, 302);
                }

                if ($ParamCheck == "EachSales") {
                    $EachSalesMotorcycles = $this->MotorcycleService->EachSales($request);
                    return response()->json($EachSalesMotorcycles, 302);
                }
            }
            case "POST":
            {
                if ($ParamCheck == "AddStock") {
                    $StockMotorcycles = $this->MotorcycleService->AddStock($request);
                    return response()->json($StockMotorcycles, 302);
                }
            }

            case "PUT":
            {

            }

            case "DELETE":
            {

            }
        }
        return response()->json([
            "Param" => $request->route('Specified'), 
            "Query" => $request->query('Query'), 
            $MethodReceived], 200);
    }
}
