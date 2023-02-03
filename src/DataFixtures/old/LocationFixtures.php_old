<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class LocationFixtures extends Fixture

{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
         $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $locations = [
            [
                "name" => "Back",
            ],

            [
                "name" => "Chest",
            ],

            [
                "name" => "Feet",
            ],

            [
                "name" => "Hands",
            ],

            [
                "name" => "Head",
            ],

            [
                "name" => "Legs",
            ],

            [
                "name" => "Main Hand",
            ],

            [
                "name" => "Neck",
            ],

            [
                "name" => "Offhand",
            ],

            [
                "name" => "Relic-Wand-Ranged",
            ],

            [
                "name" => "Ring 1",
            ],

            [
                "name" => "Ring 2",
            ],

            [
                "name" => "Shoulders",
            ],

            [
                "name" => "Trinket 1",
            ],

            [
                "name" => "Trinket 2",
            ],

            [
                "name" => "Trinket 3",
            ],

            [
                "name" => "Waist",
            ],

            [
                "name" => "Wrists",
            ],
        ];

        $locationsObjArray = [];
        foreach ($locations as $currentLocation) {
            
            $locationObj = new Location();

            $locationObj->setName($currentLocation['name']);

            $locationObj->setSlug($this->slugger->slug(mb_strtolower($currentLocation['name'])));

            $manager->persist($locationObj);

            //* reference to link fixtures files
            $this->addReference($currentLocation['name'], $locationObj);
 
        }

        $manager->flush();
    }
}
