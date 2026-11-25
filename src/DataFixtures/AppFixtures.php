<?php

namespace App\DataFixtures;

use App\Factory\AuteurFactory;
use App\Factory\CategorieFactory;
use App\Factory\ExemplaireFactory;
use App\Factory\OeuvreFactory;
use App\Factory\TypeOeuvreFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TypeOeuvreFactory::createMany(6);
        CategorieFactory::createMany(10);
        AuteurFactory::createMany(20);
        OeuvreFactory::createMany(50);
        ExemplaireFactory::createMany(60);

        UtilisateurFactory::createMany(20);
        
        $manager->flush();
    }
}
