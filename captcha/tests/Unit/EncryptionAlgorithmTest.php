<?php

namespace Tests\Unit;

use App\Http\Controllers\API\Ecryption\AES256Cipher;
use Tests\TestCase;

class EncryptionAlgorithmTest extends TestCase
{
    public function test_encryption_algorithm(): void
    {
        $algorithm = new AES256Cipher();
        $string_to_encrypt = 'Secret message';
        $encrypted_string = $algorithm->encrypt($string_to_encrypt);
        $this->assertEquals($string_to_encrypt, $algorithm->decrypt($encrypted_string));
    }
}
