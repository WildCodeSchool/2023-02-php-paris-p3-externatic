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

        for ($i = 1; $i <= 6; $i++) {
            $offer = new Offer();

            $offer->setTitle($faker->word())
                ->setCreatedAt($faker->dateTime())
                ->setStartAt($faker->dateTime())
                ->setContract($faker->word())
                ->setWorkFromHome($faker->word())
                ->setDescription($faker->paragraph())
                ->setExperience($faker->word())
                ->setMinSalary($faker->numberBetween(30000, 39000))
                ->setMaxSalary($faker->numberBetween(40000, 60000))
                ->setLocation($faker->city())
                ->setInterviewProcess($faker->sentence())
                ->setNumber($i);

            foreach (SkillFixtures::SKILLS as $key => $skill) {
                $offer->addSkill($this->getReference('skill_' .  $key));
                $skill = $skill;
            }

            if ($i < 3) {
                $offer->setUser($this->getReference('user_' . 'atos@hotmail.fr')->getCompany());
            } else {
                $offer->setUser($this->getReference('user_' . 'mcdo@hotmail.fr')->getCompany());
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
