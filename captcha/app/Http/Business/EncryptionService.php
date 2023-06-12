<?php

namespace App\Http\Business;

use App\Http\Business\Ecryption\IEncryptionAlgorithm;

class EncryptionService {
    private IEncryptionAlgorithm $algortith;
    private KeyManager $keyManager;

    public function __construct(IEncryptionAlgorithm $algortith) {
        $this->algortith = $algortith;
        $this->keyManager = new KeyManager();
    }

    public function encryptWithActiveKey(string $data): string {
        $key = $this->keyManager->getKey($this->keyManager->getActiveKeyNumber());
        return $this->algortith->encrypt($data, $key);
    }

    public function encrypt (string $data, string $key): string {
        return $this->algortith->encrypt($data, $key);
    }

    public function decrypt(string $data, string $key): string {
        return $this->algortith->decrypt($data, $key);
    }

    public function decryptWithKeyNumber (string $data, int $key_number) : string {
        return $this->decrypt($data, $this->keyManager->getKey($key_number));
    }
}