<?php

namespace App\Http\Business\Ecryption;

use App\Http\Controllers\KeyController;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;

class AES256Cipher implements IEncryptionAlgorithm {

    private string $cipher = 'aes-256-cbc';

    public function encrypt($data) : string {
        $encrypter = new Encrypter(KeyController::getActiveKeyValue(), $this->cipher);
        return $encrypter->encryptString($data);
    }

    public function decrypt($data) : string {
        try {
            $decrypter = new Encrypter(KeyController::getActiveKeyValue(), $this->cipher);
            return $decrypter->decryptString($data);
        } catch (DecryptException $e) {
            return $e->getMessage();
        }
    }
}

