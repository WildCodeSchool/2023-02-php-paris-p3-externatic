<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 60; $i++) {
            $offer = new Offer();

            $offer->setTitle($faker->text(50))
                ->setCreatedAt($faker->dateTimeBetween('-50 week', '-1 week'))
                ->setStartAt($faker->dateTime())
                ->setContract($faker->word())
                ->setWorkFromHome($faker->word())
                ->setDescription($faker->paragraph())
                ->setExperience($faker->word())
                ->setMinSalary($faker->numberBetween(30000, 39000))
                ->setMaxSalary($faker->numberBetween(40000, 60000))
                ->setLocation($faker->city())
                ->setInterviewProcess($faker->sentence())
                ->setNumber($i)
                ->setPicture('offerPictures' . mt_rand(1, 4) . '.jpg');
            for ($j = 0; $j < 6; $j++) {
                $offer->addSkill($this->getReference('skill_soft_' . $faker->unique(true)->numberBetween(1, 8)));
                $offer->addSkill($this->getReference('skill_hard_' . $faker->unique(true)->numberBetween(1, 8)));
            }

            if ($i < 31) {
                $offer->setCompany($this->getReference('user_' . 'atos@hotmail.fr')->getCompany());
            } else {
                $offer->setCompany($this->getReference('user_' . 'mcdo@hotmail.fr')->getCompany());
            }

            $manager->persist($offer);
            $this->addReference('offer_' . $offer->getNumber(), $offer);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SkillFixtures::class,
            UserFixtures::class
        ];
    }
}
