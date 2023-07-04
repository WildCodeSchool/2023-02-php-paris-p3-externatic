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
    public const LOGO = [
        'logoCompany.jpg', 'logoCompany1.jpg'
    ];
    public const USER = [
        [
            'Firstname' => 'Erika', 'Lastname' => 'Ikelempo', 'Role' => User::ROLE_CANDIDATE,
            'Location' => 'Epinay', 'Email' => 'erika@hotmail.fr', 'picture' => 'eri.png'
        ],
        [
            'Firstname' => 'Lionel', 'Lastname' => 'Da Rosa', 'Role' => User::ROLE_CANDIDATE,
            'Location' => 'Boulbi', 'Email' => 'lio@hotmail.fr', 'picture' => 'Lio.png'
        ],
        [
            'Firstname' => 'Ester', 'Lastname' => 'Martinez', 'Role' => User::ROLE_CANDIDATE,
            'Location' => 'Paris', 'Email' => 'ester@hotmail.fr', 'picture' => 'Ester.png'
        ],
        [
            'Firstname' => 'Lea', 'Lastname' => 'Hadida', 'Role' => User::ROLE_CANDIDATE,
            'Location' => 'Paris', 'Email' => 'lea@hotmail.fr', 'picture' => 'Lea.png'
        ],
        ['Name' => 'Atos', 'Role' => User::ROLE_COMPANY, 'Email' => 'atos@hotmail.fr'],
        ['Name' => 'McDonalds', 'Role' => User::ROLE_COMPANY, 'Email' => 'mcdo@hotmail.fr']
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (self::USER as $person) {
            if ($person['Role'] == User::ROLE_CANDIDATE) {
                $candidate = new Candidate();

                $candidate->setFirstname($person['Firstname'])
                    ->setLastname($person['Lastname'])
                    ->setLocation($faker->city())
                    ->setPhone($faker->phoneNumber())
                    ->setResume($faker->word())
                    ->setIntroduction($faker->paragraph())
                    ->setJobTitle($faker->word())
                    ->setExperience($faker->word())
                    ->setVisible($faker->boolean())
                    ->setPicture($person['picture']);
                for ($i = 0; $i < 6; $i++) {
                    $candidate->addSkill($this->getReference('skill_soft_' . $faker->unique(true)
                        ->numberBetween(1, 8)));
                    $candidate->addSkill($this->getReference('skill_hard_' . $faker->unique(true)
                        ->numberBetween(1, 8)));
                }

                $user = new User();

                $user->setRoles([$person['Role']])
                    ->setLogin($person['Email'])
                    ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                    ->setCandidate($candidate);

                $manager->persist($user);

                $this->addReference('user_' . $user->getLogin(), $user);
            } elseif ($person['Role'] == User::ROLE_COMPANY) {
                $company = new Company();

                $company->setName($person['Name'])
                    ->setType($faker->word())
                    ->setSector($faker->word())
                    ->setPresentation($faker->paragraph())
                    ->setLocation($faker->city())
                    ->setLogo(self::LOGO[mt_rand(0, count(self::LOGO) - 1)]);

                $user = new User();

                $user->setRoles([$person['Role']])
                    ->setLogin($person['Email'])
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
