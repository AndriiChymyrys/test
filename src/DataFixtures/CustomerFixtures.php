<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer = new Customer();
        $customer->setFirstName('Daryl')
            ->setLastName('Lambert')
            ->setEmail('daryl.lambert@example.com')
            ->setCountry('Australia')
            ->setCity('Warragul')
            ->setUsername('ticklishbutterfly378')
            ->setGender('male')
            ->setPhone('02-9453-3200');

        $manager->persist($customer);

        $customer = new Customer();
        $customer->setFirstName('Daryl')
            ->setLastName('Lambert')
            ->setEmail('daryl.lambert@example.com')
            ->setCountry('Australia')
            ->setCity('Warragul')
            ->setUsername('ticklishbutterfly378')
            ->setGender('female')
            ->setPhone('02-9453-3200');

        $manager->persist($customer);

        $manager->flush();
    }
}
