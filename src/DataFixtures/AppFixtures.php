<?php

namespace App\DataFixtures;

use App\Entity\Logement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private EntityManagerInterface $entityManager;
    private Generator $faker;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->addHouse();

        //$manager->flush();
    }

    public function addHouse(){

        $house = new Logement();

        $house
            ->setType($this->faker->randomElement(['Maison', 'Appartement', 'Manoir']))
            ->setGarage($this->faker->randomElement(['true', 'false']))
            ->setPrix(rand(150000,6500000))
            ->setAdresse($this->faker->address);
    }
}
