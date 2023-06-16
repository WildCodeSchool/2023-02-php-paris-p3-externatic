<?php

namespace App\DataFixtures;

use App\Entity\CandidateMetadata;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MetadataFixtures extends Fixture implements DependentFixtureInterface
{
    public const METADATA = ['linkedin', 'GitHub', 'portfolio'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (UserFixtures::USER as $user) {
            if ($user['Role'] == 'ROLE_CANDIDATE') {
                foreach (self::METADATA as $type) {
                    $metadata = new CandidateMetadata();

                    $metadata->setType($type)
                        ->setMetadata($faker->url())
                        ->setCandidate($this->getReference('user_' . $user['email'])->getCandidate());

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
