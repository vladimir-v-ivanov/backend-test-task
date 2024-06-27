<?php

namespace DataFixtures;

use App\Entity\TaxCountry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxCountries extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $germany = new TaxCountry();
        $germany->setCountryCode('DE');
        $germany->setValue(19);
        $manager->persist($germany);

        $italy = new TaxCountry();
        $italy->setCountryCode('IT');
        $italy->setValue(22);
        $manager->persist($italy);

        $france = new TaxCountry();
        $france->setCountryCode('FR');
        $france->setValue(20);
        $manager->persist($france);

        $greece = new TaxCountry();
        $greece->setCountryCode('GR');
        $greece->setValue(24);
        $manager->persist($greece);

        $manager->flush();
    }
}
