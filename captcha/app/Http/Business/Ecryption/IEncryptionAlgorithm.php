<?php 

namespace App\Http\Business\Ecryption;

interface IEncryptionAlgorithm{
    public function encrypt(string $data, string $key) : string;
    public function decrypt(string $data, string $key) : string;
}