<?php

namespace App\DataFixtures;

use App\Entity\CandidateMetadata;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MetadataFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (UserFixtures::USER as $user) {
            if ($user['Role'] === User::ROLE_CANDIDATE) {
                foreach (CandidateMetadata::METADATA as $type) {
                    $metadata = new CandidateMetadata();

                    $metadata->setType($type)
                        ->setMetadata($faker->url())
                        ->setCandidate($this->getReference('user_' . $user['Email'])->getCandidate());

                    $manager->persist($metadata);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
