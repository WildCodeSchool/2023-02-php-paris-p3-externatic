<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    public const SKILLS = [
        ['name' => 'PHP', 'type' => 'hard'],
        ['name' => 'JS', 'type' => 'hard'],
        ['name' => 'JAVA', 'type' => 'hard'],
        ['name' => 'force de proposition', 'type' => 'soft'],
        ['name' => 'attentif', 'type' => 'soft'],
        ['name' => 'souriant', 'type' => 'soft'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILLS as $key => $oneSkill) {
            $skill = new Skill();

            $skill->setName($oneSkill['name'])
                ->setType($oneSkill['type']);

            $manager->persist($skill);

            $this->addReference('skill_' .  $key, $skill);
        }

        $manager->flush();
    }
}
