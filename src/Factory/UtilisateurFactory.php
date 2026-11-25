<?php

namespace App\Factory;

use App\Entity\Utilisateur;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Utilisateur>
 */
final class UtilisateurFactory extends PersistentObjectFactory
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
        return Utilisateur::class;
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
            'dateCreation' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-2 years', 'now', 'Europe/Paris')),
            'dateModification' => new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')),
            'email' => self::faker()->unique()->email(),
            'mdp' => self::faker()->password(),
            'nom' => self::faker()->lastName(),
            'prenom' => self::faker()->firstName(),
            'roles' => ['ROLE_USER'],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Utilisateur $utilisateur): void {})
        ;
    }
}
