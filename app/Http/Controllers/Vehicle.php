<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Motorcycles;
use App\Http\Controllers\Cars;
class Vehicle extends Controller
{
    /**
     * @param Price Core of Vehicle
     * @param Colors Core of Vehicle
     * @param ReleaseModel Core of Vehicle
     */
    public $ReleaseModel;
    public $Colors;
    public $Price;
    public $StockVehicle;
    protected $CarsService;
    protected $MotorcycleService;

    public function __construct(Cars $FunctionCarsService, Motorcycles $FunctionMotorcycleService) {
        $this->CarsService = $FunctionCarsService;
        $this->MotorcycleService = $FunctionMotorcycleService;
    }
    public function Motorcycles(Request $request) 
    {
        $MethodReceived = strtoupper($request->method());
        $ParamCheck = $request->route('Specified');
        switch ($MethodReceived) {
            case "GET" :
            {
                // Optimal Solution are Loop but hindering by $this->MotorcycleService
                if ($ParamCheck == "Stock") {
                    $StockMotorcycles = $this->MotorcycleService->Stock();
                    return response()->json($StockMotorcycles, 200);
                } break;

                if ($ParamCheck == "Sales") {
                    $this->MotorcycleService->DataBulk($request);
                    $SalesMotorcycles = $this->MotorcycleService->Sales($request);
                    return response()->json($SalesMotorcycles, 200);
                } break;

                if ($ParamCheck == "EachSales") {
                    $this->MotorcycleService->DataBulk($request);
                    $EachSalesMotorcycles = $this->MotorcycleService->EachSales($request);
                    return response()->json($EachSalesMotorcycles, 200);
                } break;
            }
            case "POST":
            {
                if ($ParamCheck == "AddStock") {
                    $this->MotorcycleService->DataBulk($request);
                    $StockMotorcycles = $this->MotorcycleService->AddStock();
                    return response()->json($StockMotorcycles, 201);
                } break;
            }

            case "PUT":
            {
                if ($ParamCheck == "UpdateStock") {
                    $UpdateMotorcycles = $this->MotorcycleService->UpdateStock($request);
                    return response()->json($UpdateMotorcycles, 200);
                }
            }
        }
        return response()->json([
            "Param" => $request->route('Specified'), 
            "Query" => $request->query('Query'), 
            $MethodReceived], 200);
    }

    public function Cars(Request $request) 
    {
        $MethodReceived = strtoupper($request->method());
        $ParamCheck = $request->route('Specified');
        switch ($MethodReceived) {
            case "GET" :
            {
                // Optimal Solution are Loop but hindering by $this->MotorcycleService
                if ($ParamCheck == "Stock") {
                    $this->CarsService->DataBulk($request);
                    $StockCars = $this->CarsService->Stock();
                    return response()->json($StockCars, 200);
                } break;

                if ($ParamCheck == "Sales") {
                    $this->CarsService->DataBulk($request);
                    $SalesCars = $this->CarsService->Sales($request);
                    return response()->json($SalesCars, 200);
                } break;

                if ($ParamCheck == "EachSales") {
                    $this->CarsService->DataBulk($request);
                    $EachSalesCars = $this->CarsService->EachSales($request);
                    return response()->json($EachSalesCars, 200);
                } break;
            }
            case "POST":
            {
                if ($ParamCheck == "AddStock") {
                    $this->CarsService->DataBulk($request);
                    $AddCars = $this->CarsService->AddStock();
                    return response()->json([
                        "AddStock" => $AddCars->isAcknowledged(),
                        "Messages" => $AddCars->isAcknowledged() ? "Sucessfully" : null,
                    ], 201);
                } break;
            }

            case "PUT":
            {
                // First Time Newb Here to Understanding How MongoDB Work
                if ($ParamCheck == "UpdateStock") {
                    $this->CarsService->DataBulk($request);
                    $UpdateCars = $this->CarsService->UpdateStock($request);
                    return response()->json($UpdateCars, 200);
                }
            }
        }
        return response()->json([
            "Param" => $request->route('Specified'), 
            "Query" => $request->query('Query'), 
            $MethodReceived], 200);
    }
}
