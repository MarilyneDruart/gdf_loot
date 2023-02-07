<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PlayerFixtures extends Fixture implements DependentFixtureInterface 
{
    
    public function getDependencies()
   {
        return [
            ItemFixtures::class,
        ];
    }

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
         $this->slugger = $slugger;
    }
    
    public function load(ObjectManager $manager): void
    {

        $players = [

            [
                "name" => "Arianhrod",
                "class" => "Druide",
                "score" => "0",
                "role" => "Tank",
                "rank" => "Sérieux",
                "is_actif" => "1",
                "item" => "Ambition infinie",
                "raid" => "Naxxramas",
            ],

            // [
            //     "name" => "Atanea",
            //     "class" => "Prêtre",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Belzedar",
            //     "class" => "Prêtre",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Bourla",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Burgrogue",
            //     "class" => "Voleur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Camchoupette",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Cegar",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Cheren",
            //     "class" => "Chasseur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Chipmage",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Chpok",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Demoralyse",
            //     "class" => "Démoniste",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Ekte",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Elvi",
            //     "class" => "Chevalier de la mort",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Euphorus",
            //     "class" => "Voleur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Farah",
            //     "class" => "Chevalier de la mort",
            //     "score" => "0",
            //     "role" => "Tank",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Floriel",
            //     "class" => "Druide",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Gazzole",
            //     "class" => "Voleur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Grymn",
            //     "class" => "Guerrier",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Gulliver",
            //     "class" => "Démoniste",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Gwen",
            //     "class" => "Druide",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Icekarr",
            //     "class" => "Chaman",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Judgentix",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Kamari",
            //     "class" => "Chasseur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Keny",
            //     "class" => "Chevalier de la mort",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Kwaky",
            //     "class" => "Démoniste",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Lady",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Limdul",
            //     "class" => "Prêtre",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Lucamar",
            //     "class" => "Druide",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Maxxam",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Mealyn",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Mjol",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Necrogirl",
            //     "class" => "Démoniste",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Portish",
            //     "class" => "Prêtre",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Pyro",
            //     "class" => "Guerrier",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Rim",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Schaga",
            //     "class" => "Chaman",
            //     "score" => "0",
            //     "role" => "Healer",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Selena",
            //     "class" => "Druide",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Sha",
            //     "class" => "Chevalier de la mort",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Skenz",
            //     "class" => "Chaman",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Sunks",
            //     "class" => "Voleur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Tanriel",
            //     "class" => "Chasseur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Galopin",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Tindu",
            //     "class" => "Guerrier",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Ulmo",
            //     "class" => "Voleur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Untardo",
            //     "class" => "Chasseur",
            //     "score" => "0",
            //     "role" => "CAC",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Vali",
            //     "class" => "Paladin",
            //     "score" => "0",
            //     "role" => "Tank",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Vultris",
            //     "class" => "Démoniste",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
                        
            // [
            //     "name" => "Xamena",
            //     "class" => "Mage",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Demi",
            //     "is_actif" => "1",
            // ],
            
            // [
            //     "name" => "Youyou",
            //     "class" => "Druide",
            //     "score" => "0",
            //     "role" => "Caster",
            //     "rank" => "Sérieux",
            //     "is_actif" => "1",
            // ],
            
        ];

        $playersObjArray = [];
        foreach ($players as $currentPlayer) {
            
            $playerObj = new Player();

            $playerObj->setName($currentPlayer['name']);
            $playerObj->setClass($currentPlayer['class']);
            $playerObj->setScore($currentPlayer['score']);
            $playerObj->setRank($currentPlayer['rank']);
            $playerObj->setIsActif($currentPlayer['is_actif']);

            $playerObj->setSlug($this->slugger->slug(mb_strtolower($currentPlayer['name'])));

            $roleObj = $this->getReference($currentPlayer["role"]);
            $playerObj->setRole($roleObj);

            $itemObj = $this->getReference($currentPlayer["item"]);
            $playerObj->addItem($itemObj);

            $raidObj = $this->getReference($currentPlayer["raid"]);
            $playerObj->addRaid($raidObj);

            $manager->persist($playerObj);

            //* reference to link fixtures files
            $this->addReference($currentPlayer['name'], $playerObj);
 
        }


        $manager->flush();
    }
}
