<?php

namespace Tests\Unit;

use App\Http\Business\ProofOfWorkDetails;
use PHPUnit\Framework\TestCase;

class ProofOfWorkDetailsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    protected ProofOfWorkDetails $proof_of_work_details;

    protected function setUp(): void
    {
        parent::setUp();
        $this->proof_of_work_details = new ProofOfWorkDetails("918f18773e278d883efe4d8c8be3b08e7b587238bb81b9fabd8440f94041d8ec");
    }

    public function test_proof_of_work_details() : void
    {
        $fixed_strings = $this->proof_of_work_details->getFixedString();
        $this->assertEquals(22, strlen($fixed_strings[0]));
        $this->assertEquals(21, strlen($fixed_strings[1]));
        $this->assertEquals(21, strlen($fixed_strings[2]));
        $this->assertContainsOnly('string', $fixed_strings);
    }
}
