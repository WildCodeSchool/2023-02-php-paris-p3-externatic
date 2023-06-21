<?php

namespace App\DataFixtures;

use App\Entity\Application;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public const APPLICATION_STATUS = ['received', 'in review', 'accepted', 'rejected'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (self::APPLICATION_STATUS as $status) {
            $application = new Application();

            $application->setStatus($status)
                ->setCreatedAt($faker->dateTime())
                ->setOffer($this->getReference('offer_' . rand(1, 6)))
                ->setCandidate($this->getReference('user_' . UserFixtures::USER[rand(0, 3)]['Email'])->getCandidate());

            $manager->persist($application);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OfferFixtures::class,
            UserFixtures::class
        ];
    }
}
