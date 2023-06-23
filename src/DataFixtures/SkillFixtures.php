<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    public const SKILLS = [
        [
            ['name' => 'PHP', 'type' => 'hard'],
            ['name' => 'JS', 'type' => 'hard'],
            ['name' => 'JAVA', 'type' => 'hard'],
            ['name' => 'Windev', 'type' => 'hard'],
            ['name' => 'html', 'type' => 'hard'],
            ['name' => 'CSS', 'type' => 'hard'],
            ['name' => 'PHP1', 'type' => 'hard'],
            ['name' => 'JS1', 'type' => 'hard'],
            ['name' => 'JAVA1', 'type' => 'hard'],
            ['name' => 'Windev1', 'type' => 'hard'],
            ['name' => 'html1', 'type' => 'hard'],
            ['name' => 'CSS1', 'type' => 'hard'],
        ],
        [
            ['name' => 'full of idea', 'type' => 'soft'],
            ['name' => 'alert', 'type' => 'soft'],
            ['name' => 'smiling', 'type' => 'soft'],
            ['name' => 'nice', 'type' => 'soft'],
            ['name' => 'inventive', 'type' => 'soft'],
            ['name' => 'perfectionist', 'type' => 'soft'],
            ['name' => 'full of idea1', 'type' => 'soft'],
            ['name' => 'alert1', 'type' => 'soft'],
            ['name' => 'smiling1', 'type' => 'soft'],
            ['name' => 'nice1', 'type' => 'soft'],
            ['name' => 'inventive1', 'type' => 'soft'],
            ['name' => 'perfectionist1', 'type' => 'soft'],
        ]

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILLS as $type) {
            foreach ($type as $key => $oneSkill) {
                $skill = new Skill();

                $skill->setName($oneSkill['name'])
                    ->setType($oneSkill['type']);

                $manager->persist($skill);

                $this->addReference('skill_' . $skill->getType() . '_' .  $key, $skill);
            }
        }
        $manager->flush();
    }
}
