<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain;

use IWannaEat\Domain\EmailAddress;
use PHPUnit\Framework\TestCase;

class EmailAddressTest extends TestCase
{
    /** @test */
    public function it_holds_email_address(): void
    {
        $email = 'kev@test.com';
        $this->assertSame($email, (new EmailAddress($email))->toString());
    }

    /** @test */
    public function it_throws_error_if_invalid_email_address(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid email address.');

        new EmailAddress('invalid email');
    }
}
