<?php

namespace App\Http\Business;

class SolutionConverter {
    public static function convertToJsonString(string $solution) : string {
        $obj = new \stdClass();
        $obj->solution = $solution;
        $obj->time = time();
        return json_encode($obj);
    }

    public static function extractSolutionFromJsonString(string $data) : string {
        $obj = json_decode($data);
        return $obj->solution;
    }
}