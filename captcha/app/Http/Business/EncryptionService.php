<?php

namespace App\Http\Business;

use App\Http\Business\Ecryption\IEncryptionAlgorithm;
use App\Models\Key;

class EncryptionService {
    private IEncryptionAlgorithm $algortith;

    public function __construct(IEncryptionAlgorithm $algortith) {
        $this->algortith = $algortith;
    }

    public function encryptWithActiveKey(string $data): string {
        $key = KeyManager::getKey(KeyManager::getActiveKeyNumber());
        return $this->algortith->encrypt($data, $key);
    }

    public function encrypt (string $data, string $key): string {
        return $this->algortith->encrypt($data, $key);
    }

    public function decrypt(string $data, string $key): string {
        return $this->algortith->decrypt($data, $key);
    }

    public function decryptWithKeyNumber (string $data, int $key_number) : string {
        return $this->decrypt($data, KeyManager::getKey($key_number));
    }
}