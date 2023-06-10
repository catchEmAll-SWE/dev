<?php

namespace Tests\Unit;

use App\Http\Business\Verify\POWVerifier;
use PHPUnit\Framework\TestCase;

class POWVerifierTest extends TestCase
{
    /**
     * testare i 2 casi in cui ritorna true o false
     * 
     */

    protected POWVerifier $pow_verifier_correct;
    protected POWVerifier $pow_verifier_wrong;

    protected function setUp() : void {
        parent::setUp();
        $this->pow_verifier_correct = new POWVerifier(array("3f42696d757d4fed9aaf43","b10a90ce9eda297a315cb","a83a118677a9e8a4ccae6"), array("10540","71748","95614"));
        $this->pow_verifier_wrong = new POWVerifier(array("3f42696d757d4fed9aaf43","b10a90ce9eda297a315cb","a83a118677a9e8a4ccae6"), array("58","172","237"));
    }

    public function test_verify_pow_true(){
        $this->assertTrue($this->pow_verifier_correct->verify());
    }

    public function test_verify_pow_false(){
        $this->assertFalse($this->pow_verifier_wrong->verify());
    }

}
