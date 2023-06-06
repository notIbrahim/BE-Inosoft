<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use MongoDB\Client;
use Illuminate\Support\Facades\Config;

class DB extends Controller
{
    private $DB;
    private $Client;
    private $Collection;

    public function __construct($t_DB = Null, $t_Collection, $t_Client = Null)
    { 
        $this->Client = new Client($t_Client);
        $this->DB = $this->Client->selectDatabase($t_DB);
        $this->Collection = $this->DB->selectCollection($t_Collection);
        ($this->Collection && $this->DB) ? : throw new Error("Database or Collection does not match or exists please insert properly database or collection", 500);
        // if ((bool)$Collection == True && (bool)$DB == True) {
        //     return $Collection;
        // } 
        // else 
        // {
        //     throw new Error("Database or Collection does not match or exists please insert properly database or collection", 500);
        // }
    }
 
    public function CallDatabase()
    {
        return $this->Collection;
    }
}
