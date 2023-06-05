<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use MongoDB\Client;

class DB extends Controller
{
    private $DB;
    private $Client;
    private $Collection;

    public function SetConstruct($t_DB, $t_Collection, $t_Client)
    { 
        $this->Client = new Client($t_Client);
        $this->DB = $this->Client->selectDatabase($t_DB);
        $this->Collection = $this->DB->selectCollection($t_Collection);
        ($this->Collection && $this->DB) ? : throw new Error("Database or Collection does not match or exists please insert properly database or collection", 500);
        return $this->Collection;
        // if ((bool)$Collection == True && (bool)$DB == True) {
        //     return $Collection;
        // } 
        // else 
        // {
        //     throw new Error("Database or Collection does not match or exists please insert properly database or collection", 500);
        // }
    }
}
