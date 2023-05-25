<?php

namespace Tests\Unit;

use App\Http\Business\Ecryption\AES256Cipher;
use Tests\TestCase;

class EncryptionAlgorithmTest extends TestCase
{
    /**
     * verify that the encryption algorithm works correctly
     * by encrypt a string and then verify it equals to decrypt of the encrypted one
     */
    public function test_encryption_algorithm(): void
    {
        $algorithm = new AES256Cipher();
        $string_to_encrypt = 'Secret message';
        $encrypted_string = $algorithm->encrypt($string_to_encrypt);
        $this->assertEquals($string_to_encrypt, $algorithm->decrypt($encrypted_string));
    }
}
