<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (skill::SKILLS as $type) {
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
