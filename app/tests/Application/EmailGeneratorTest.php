<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application;

use Assert\Assertion;
use IWannaEat\Application\EmailAddressGenerator;
use PHPUnit\Framework\TestCase;

class EmailGeneratorTest extends TestCase
{
    private EmailAddressGenerator $emailAddressGenerator;

    protected function setUp(): void
    {
        $this->emailAddressGenerator = new EmailAddressGenerator();
    }

    /** @test */
    public function it_generates_random_valid_emails(): void
    {
        $testIterations = 100;
        while ($testIterations > 0) {
            $emailAddress = $this->emailAddressGenerator->generate();

            $this->assertTrue(Assertion::email($emailAddress->toString()));
            $testIterations--;
        }
    }
}
