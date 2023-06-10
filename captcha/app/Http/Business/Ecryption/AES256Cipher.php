<?php

namespace App\Http\Business\Ecryption;

use App\Http\Business\KeyManager;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;

class AES256Cipher implements IEncryptionAlgorithm {

    public function encrypt(string $data, string $key) : string {
        $encrypter = new Encrypter($key, 'aes-256-cbc');
        return $encrypter->encryptString($data);
    }

    public function decrypt(string $data, string $key) : string {
        try {
            $decrypter = new Encrypter($key, 'aes-256-cbc');
            return $decrypter->decryptString($data);
        } catch (DecryptException $e) {
            return $e->getMessage();
        }
    }
}

