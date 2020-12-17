<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $property1 = new Property();
        $property1->setTitle('Mon premier bien')
                ->setPrice(200000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Petit appartement en centre ville')
                ->setSurface(75)
                ->setFloor(4)
                ->setHeat(1)
                ->setCity('Rennes')
                ->setAddress('23 Boulevard Gambetta')
                ->setPostalCode('35100');
        $manager->persist($property1);
        $property2 = new Property();
        $property2->setTitle('Mon deuxieme bien')
                ->setPrice(150000)
                ->setRooms(6)
                ->setBedrooms(4)
                ->setDescription('maison de campagne')
                ->setSurface(100)
                ->setFloor(1)
                ->setHeat(1)
                ->setCity('La Chapelle aux Filtzmeens')
                ->setAddress('3 Allée de l\'Ongraie')
                ->setPostalCode('35190');
        $manager->persist($property2);
        $property3 = new Property();
        $property3->setTitle('Mon troisieme bien')
                ->setPrice(250000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Maison en ville')
                ->setSurface(80)
                ->setFloor(0)
                ->setHeat(1)
                ->setCity('Dinan')
                ->setAddress('34 rue de Brest')
                ->setPostalCode('22100');
        $manager->persist($property3);

        $manager->flush();
    }
}
