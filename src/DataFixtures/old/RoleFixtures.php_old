<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RoleFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
         $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $roles = [
            [
                "name" => "CAC",
            ],

            [
                "name" => "Caster",
            ],

            [
                "name" => "Healer",
            ],

            [
                "name" => "Tank",
            ],
        ];
        $rolesObjArray = [];
        foreach ($roles as $currentRole) {
            
            $roleObj = new Role();
            $roleObj->setName($currentRole['name']);
            $roleObj->setSlug($this->slugger->slug(mb_strtolower($currentRole['name'])));

            $manager->persist($roleObj);

            //* reference to link fixtures files
            $this->addReference($currentRole['name'], $roleObj);
 
        }

        $manager->flush();
    }
}