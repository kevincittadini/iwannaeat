<?php

namespace IWannaEat\Application;

use IWannaEat\Domain\EmailAddress;

interface EmailAddressGeneratorInterface
{
    public function generate(): EmailAddress;
}
