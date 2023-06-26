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


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (User::USER as $person) {
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
                        ->numberBetween(0, 11)));
                    $candidate->addSkill($this->getReference('skill_hard_' . $faker->unique(true)
                        ->numberBetween(0, 11)));
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
                    ->setLogo(User::LOGO[mt_rand(0, count(User::LOGO) - 1)]);

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
