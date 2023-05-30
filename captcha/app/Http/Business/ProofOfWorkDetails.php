<?php

namespace App\Http\Business;

class ProofOfWorkDetails{
    private $fixed_string = [];
    private static string $difficulty = '00';

    public function __construct(string $id){
        $this->fixed_string = $this->getSplittedId($id);
    }

    private function getSplittedId(string $id) : array {
        return [substr($id, 0, 22), substr($id, 22, 21), substr($id, 43, 21)];
    }

    public function getFixedString():array{
        return $this->fixed_string;
    }

    public static function getDifficulty(){
        return ProofOfWorkDetails::$difficulty;
    }
}