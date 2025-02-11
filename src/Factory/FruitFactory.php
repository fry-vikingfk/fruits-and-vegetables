<?php

namespace App\Factory;

use App\Entity\Fruit;
use App\Enum\WeightUnitTypeEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Fruit>
 */
final class FruitFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Fruit::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->text(255),
            'unit' => self::faker()->randomElement(WeightUnitTypeEnum::cases()),
            'quantity' => self::faker()->numberBetween(1, 200),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Fruit $fruit): void {})
        ;
    }
}
