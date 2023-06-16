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
            ['name' => 'force de proposition', 'type' => 'soft'],
            ['name' => 'attentif', 'type' => 'soft'],
            ['name' => 'souriant', 'type' => 'soft'],
            ['name' => 'gentil', 'type' => 'soft'],
            ['name' => 'inventif', 'type' => 'soft'],
            ['name' => 'perfectioniste', 'type' => 'soft'],
            ['name' => 'force de proposition1', 'type' => 'soft'],
            ['name' => 'attentif1', 'type' => 'soft'],
            ['name' => 'souriant1', 'type' => 'soft'],
            ['name' => 'gentil1', 'type' => 'soft'],
            ['name' => 'inventif1', 'type' => 'soft'],
            ['name' => 'perfectioniste1', 'type' => 'soft'],
        ]

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILLS as $key => $type) {
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
