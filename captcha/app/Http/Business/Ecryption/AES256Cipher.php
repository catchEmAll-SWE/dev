<?php

namespace App\Http\Business\Ecryption;

use App\Http\Business\KeyManager;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;

class AES256Cipher implements IEncryptionAlgorithm {

    public function encrypt($data) : string {
        $encrypter = new Encrypter(KeyManager::getActiveKeyValue(), 'aes-256-cbc');
        return $encrypter->encryptString($data);
    }

    public function decrypt(string $data, int $key_number) : string {
        try {
            $key = KeyManager::getKeyValue($key_number);
            $decrypter = new Encrypter($key, 'aes-256-cbc');
            return $decrypter->decryptString($data);
        } catch (DecryptException $e) {
            return $e->getMessage();
        }
    }
}

