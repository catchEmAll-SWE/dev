<?php 

namespace App\Http\Business\Ecryption;

use App\Http\Business\KeyManager;

interface IEncryptionAlgorithm{
    public function encrypt(string $data) : string;
    public function decrypt(string $data, int $key_number) : string;
}