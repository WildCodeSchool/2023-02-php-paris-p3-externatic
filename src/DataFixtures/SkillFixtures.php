<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $counter = 0;
        foreach (Skill::SKILLS as $key) {
                $skill = new Skill();

                $skill->setName($key['name'])
                    ->setType($key['type']);

            if ($key['type'] == 'hard') {
                $counter++;
                $counter = ($counter > 8) ? 1 : $counter;
            }
            if ($key['type'] == 'soft') {
                $counter++;
                $counter = ($counter > 8) ? 1 : $counter;
            }

                $manager->persist($skill);

                $this->addReference('skill_' . $skill->getType() . '_' . $counter, $skill);
        }

        $manager->flush();
    }
}
