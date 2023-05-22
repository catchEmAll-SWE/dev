<?php 

namespace App\Http\Controllers\API\Ecryption;

interface IEncryptionAlgorithm{
    public function encrypt($data) : string;
    public function decrypt($data) : string;
}