<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    public const SKILLS = [
        ['name' => 'PHP', 'type' => 'hard'],
        ['name' => 'JS', 'type' => 'hard'],
        ['name' => 'JAVA', 'type' => 'hard'],
        ['name' => 'Windev', 'type' => 'hard'],
        ['name' => 'html', 'type' => 'hard'],
        ['name' => 'CSS', 'type' => 'hard'],
        ['name' => 'PHP1', 'type' => 'hard'],
        ['name' => 'JS1', 'type' => 'hard'],
        ['name' => 'full of idea', 'type' => 'soft'],
        ['name' => 'alert', 'type' => 'soft'],
        ['name' => 'smiling', 'type' => 'soft'],
        ['name' => 'nice', 'type' => 'soft'],
        ['name' => 'inventive', 'type' => 'soft'],
        ['name' => 'perfectionist', 'type' => 'soft'],
        ['name' => 'full of idea1', 'type' => 'soft'],
        ['name' => 'alert1', 'type' => 'soft'],
    ];

    public function load(ObjectManager $manager): void
    {
        $counter = 0;
        foreach (self::SKILLS as $key) {
                $skill = new Skill();

                $skill->setName($key['name'])
                    ->setType($key['type']);

            if ($key['type'] == 'hard' || $key['type'] == 'soft') {
                $counter++;
                $counter = ($counter > 8) ? 1 : $counter;
            }

                $manager->persist($skill);

                $this->addReference('skill_' . $skill->getType() . '_' . $counter, $skill);
        }

        $manager->flush();
    }
}
