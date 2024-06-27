<?php

namespace DataFixtures;

use App\Entity\DiscountCoupon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscountCoupons extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupon15 = new DiscountCoupon();
        $coupon15->setCode('SALE15');
        $coupon15->setDiscount(15);
        $manager->persist($coupon15);

        $coupon25 = new DiscountCoupon();
        $coupon25->setCode('SALE25');
        $coupon25->setDiscount(25);
        $manager->persist($coupon25);

        $coupon35 = new DiscountCoupon();
        $coupon35->setCode('SALE35');
        $coupon35->setDiscount(35);
        $manager->persist($coupon35);

        $manager->flush();
    }
}
