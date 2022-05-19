<?php

namespace IWannaEat\Application;

use IWannaEat\Domain\Id;

interface IdGeneratorInterface
{
    public function generate(): Id;
}
