<?php

namespace App\Http\Business;

class Solution {
    private string $solution;
    private int $time;
    
    public function __construct(string $solution){
        $this->solution = $solution;
        $this->time = time();
    }

    public function getSolution(){
        return $this->solution;
    }

    public function getTime(){
        return $this->time;
    }
}