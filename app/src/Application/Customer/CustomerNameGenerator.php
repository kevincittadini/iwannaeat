<?php

declare(strict_types=1);

namespace IWannaEat\Application\Customer;

use IWannaEat\Domain\Customer\CustomerName;

final class CustomerNameGenerator implements CustomerNameGeneratorInterface
{
    private array $familyNamesRepository;
    private array $namesRepository;

    public function __construct()
    {
        $this->familyNamesRepository = [
            'Rossi', 'Bianchi', 'Ferrari', 'Russo', 'Romano', 'Gallo', 'Costa', 'Fontana',
            'Conti', 'Moretti', 'De Luca', 'Bruno', 'Santoro', 'Marini', 'Ferri', 'Morelli',
            'Pellegrini', "D'Angelo", 'Rizzi', 'Longo', 'Leone', 'Martinelli', 'Serra', 'Galli',
        ];

        $this->namesRepository = [
            'Sofia', 'Giulia', 'Aurora', 'Alice', 'Ginevra', 'Liv', 'Vittoria', 'Giorgia', 'Matilde',
            'Leonardo', 'Francesco', 'Alessandro', 'Lorenzo', 'Mattia', 'Garbiele', 'Luca', 'Andrea',
        ];
    }

    public function generate(): CustomerName
    {
        return new CustomerName(
            $this->generateFamilyName(),
            $this->generateNames()
        );
    }

    private function generateNames(): array
    {
        $names = [];
        $howManyNames = random_int(1, 3);

        while($howManyNames > 0) {
            $names[] = $this->namesRepository[random_int(0, count($this->namesRepository) - 1)];
            $howManyNames--;
        }

        return $names;
    }

    private function generateFamilyName(): string
    {
        return $this->familyNamesRepository[random_int(0, count($this->familyNamesRepository) - 1)];
    }
}
