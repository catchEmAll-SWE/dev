<?php

namespace App\Http\Business\Ecryption;

use App\Console\Commands\KeyManager;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;

class AES256Cipher implements IEncryptionAlgorithm {

    private string $cipher = 'aes-256-cbc';

    public function encrypt($data) : string {
        $encrypter = new Encrypter(KeyManager::getActiveKeyValue(), $this->cipher);
        return $encrypter->encryptString($data);
    }

    public function decrypt(string $data, int $key_number) : string {
        try {
            $key = KeyManager::getKeyValue($key_number);
            $decrypter = new Encrypter($key, $this->cipher);
            return $decrypter->decryptString($data);
        } catch (DecryptException $e) {
            return $e->getMessage();
        }
    }
}

