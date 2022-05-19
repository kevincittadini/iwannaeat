<?php

declare(strict_types=1);

namespace IWannaEat\Application;

use IWannaEat\Domain\EmailAddress;

final class EmailAddressGenerator implements EmailAddressGeneratorInterface
{
    public function generate(): EmailAddress
    {
        return new EmailAddress(
            sprintf('info+%d@example.com', random_int(1000, 9999))
        );
    }
}
