<?php 

namespace App\Http\Business\Ecryption;

interface IEncryptionAlgorithm{
    public function encrypt($data) : string;
    public function decrypt($data) : string;
}