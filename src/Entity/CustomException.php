<?php

namespace App\Entity;
use Exception;

class CustomException extends Exception
{
    protected $code;
    public function __construct($message="U",$code=500){
        $this->code=$code;
        parent::__construct($message);
    }
    public function to_json(){
        $data=[
            "code"=>$this->code,
            "message"=>$this->getMessage()
        ];
        return json_encode($data);
    }
}
