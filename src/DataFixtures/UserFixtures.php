<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Candidate;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    public const USER = [
        [
            'firstname' => 'Erika', 'lastname' => 'Ikelempo', 'Role' => 'ROLE_CANDIDATE',
            'Location' => 'Epinay', 'email' => 'erika@hotmail.fr'
        ],
        [
            'firstname' => 'Lionel', 'lastname' => 'Da Rosa', 'Role' => 'ROLE_CANDIDATE',
            'Location' => 'Boulbi', 'email' => 'lio@hotmail.fr'
        ],
        [
            'firstname' => 'Ester', 'lastname' => 'Martinez', 'Role' => 'ROLE_CANDIDATE',
            'Location' => 'Paris', 'email' => 'ester@hotmail.fr'
        ],
        [
            'firstname' => 'Lea', 'lastname' => 'Hadida', 'Role' => 'ROLE_CANDIDATE',
            'Location' => 'Paris', 'email' => 'lea@hotmail.fr'
        ],
        ['Name' => 'Atos', 'Role' => 'ROLE_COMPANY', 'email' => 'atos@hotmail.fr'],
        ['Name' => 'McDonalds', 'Role' => 'ROLE_COMPANY', 'email' => 'mcdo@hotmail.fr']
    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (self::USER as $person) {
            if ($person['Role'] == 'ROLE_CANDIDATE') {
                $candidate = new Candidate();

                $candidate->setFirstname($person['firstname'])
                    ->setLastname($person['lastname'])
                    ->setLocation($faker->city())
                    ->setPhone($faker->phoneNumber())
                    ->setResume($faker->word())
                    ->setIntroduction($faker->paragraph())
                    ->setJobTitle($faker->word())
                    ->setExperience($faker->word())
                    ->setVisible($faker->boolean());
                for ($i = 0; $i < 6; $i++) {
                    $candidate->addSkill($this->getReference('skill_soft_' . $faker->unique(true)->numberBetween(0, 11)));
                    $candidate->addSkill($this->getReference('skill_hard_' . $faker->unique(true)->numberBetween(0, 11)));
                }

                $user = new User();

                $user->setRoles([$person['Role']])
                    ->setLogin($person['email'])
                    ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                    ->setCandidate($candidate);

                $manager->persist($user);

                $this->addReference('user_' . $user->getLogin(), $user);
            } elseif ($person['Role'] == 'ROLE_COMPANY') {
                $company = new Company();

                $company->setName($person['Name'])
                    ->setType($faker->word())
                    ->setSector($faker->word())
                    ->setPresentation($faker->paragraph())
                    ->setLocation($faker->city());

                $user = new User();

                $user->setRoles([$person['Role']])
                    ->setLogin($person['email'])
                    ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                    ->setCompany($company);

                $manager->persist($user);

                $this->addReference('user_' . $user->getLogin(), $user);
            }
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SkillFixtures::class
        ];
    }
}
