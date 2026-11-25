<?php

namespace App\Factory;

use App\Entity\Oeuvre;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Oeuvre>
 */
final class OeuvreFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Oeuvre::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'dateSortie' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-50 years', 'now', 'Europe/Paris')),
            'titre' => self::faker()->words(5, true),
            'typeOeuvre' => TypeOeuvreFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Oeuvre $oeuvre): void {})
        ;
    }
}
