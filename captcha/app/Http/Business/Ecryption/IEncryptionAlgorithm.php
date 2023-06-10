<?php 

namespace App\Http\Business\Ecryption;

interface IEncryptionAlgorithm{
    public function encrypt(string $data) : string;
    public function decrypt(string $data, int $key_number) : string;
}