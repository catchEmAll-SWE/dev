<?php

namespace App\Http\Controllers\API\Ecryption;

use Illuminate\Support\Facades\Crypt;

class AES256Cipher implements IEncryptionAlgorithm {

    public function encrypt($data) : string {
        return Crypt::encryptString($data);
    }

    public function decrypt($data) : string {
        return Crypt::decryptString($data);
    }
}

