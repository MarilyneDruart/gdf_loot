<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Item;
use App\Entity\LootHistory;
use App\Entity\Slot;
use App\Entity\Participation;
use App\Entity\Player;
use App\Entity\Raid;
use App\Entity\Role;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class DataFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // ------------------------------- Raids -------------------------------
            $raidsObjArray = [
                [
                    "name" => "Hors raid",
                ],

                [
                    "name" => "L'oeil de l'éternité",
                ],

                [
                    "name" => "Le sanctum Obsidien",
                ],

                [
                    "name" => "Naxxramas",
                ],

                [
                    "name" => "Ulduar",
                ],

            ];

            // $raidsObjArray = [];
            foreach ($raidsObjArray as $currentRaid) {
                $raidObj = new Raid();

                $raidObj->setName($currentRaid['name']);
                $raidObj->setSlug($this->slugger->slug(mb_strtolower($currentRaid['name'])));

                $raidsObjArray[md5($currentRaid['name'])] = $raidObj;

                $manager->persist($raidObj);

                //* reference to link fixtures files
                $this->addReference($currentRaid['name'], $raidObj);
            }

        // ------------------------------- Roles -------------------------------
            $rolesObjArray = [

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
            // $rolesObjArray = [];
            foreach ($rolesObjArray as $currentRole) {
                $roleObj = new Role();

                $roleObj->setName($currentRole['name']);
                $roleObj->setSlug($this->slugger->slug(mb_strtolower($currentRole['name'])));

                $rolesObjArray[md5($currentRole['name'])] = $roleObj;

                $manager->persist($roleObj);

                //* reference to link fixtures files
                $this->addReference($currentRole['name'], $roleObj);
            }

        // ------------------------------- Slots -------------------------------
            $slotObjArray = [

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
                    "name" => "Ring",
                ],

                [
                    "name" => "Shoulders",
                ],

                [
                    "name" => "Trinket",
                ],

                [
                    "name" => "Waist",
                ],

                [
                    "name" => "Wrists",
                ],
            ];

            // $slotObjArray = [];
            foreach ($slotObjArray as $currentSlot) {
                $slotObj = new Slot();

                $slotObj->setName($currentSlot['name']);
                $slotObj->setSlug($this->slugger->slug(mb_strtolower($currentSlot['name'])));

                $slotObjArray[md5($currentSlot['name'])] = $slotObj;

                $manager->persist($slotObj);
            }

        // ------------------------------- Items -------------------------------
            $itemsObjArray = [
                [
                    "id" => "45246",
                    "name" => "Aiguillon en éclat de golem",
                    "slot" => [
                        "Main Hand",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45246/aiguillon-en-%C3%A9clat-de-golem",
                ],
                [
                    "id" => "46068",
                    "name" => "Amict de l'horreur inconcevable",
                    "slot" => [
                        "Shoulders",
                    ],
                    "type" => "HM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=46068/amict-de-lhorreur-inconcevable",
                ],
                [
                    "id" => "45253",
                    "name" => "Amulette du renouveau en saphir",
                    "slot" => [
                        "Neck",
                    ],
                    "type" => "",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45243/amulette-du-renouveau-en-saphir",
                ],
                [
                    "id" => "46322",
                    "name" => "Anneau à cachet de Brann",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "HM",
                    "raid" => "Hors raid",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=46322/anneau-%C3%A0-cachet-de-brann",
                ],
                [
                    "id" => "45250",
                    "name" => "Anneau de l'assemblage fou",
                    "slot" => [
                        "",
                    ],
                    "type" => "",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45250/anneau-de-lassemblage-fou",
                ],
                [
                    "id" => "45157",
                    "name" => "Anneau de l'éclat de cendre",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45157/anneau-de-l%C3%A9clat-de-cendre",
                ],
                [
                    "id" => "45515",
                    "name" => "Anneau de l'oeil vacant",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45515/anneau-de-loeil-vacant",
                ],
                [
                    "id" => "45418",
                    "name" => "Anneau en saphir de dame Maye",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45418/anneau-en-saphir-de-dame-maye",
                ],
                [
                    "id" => "45570",
                    "name" => "Arbalète forge-ciel",
                    "slot" => [
                        "Relic-Wand-Ranged",
                    ],
                    "type" => "HM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45570/arbal%C3%A8te-forge-ciel",
                ],
                [
                    "id" => "46046",
                    "name" => "Bague de la nébuleuse",
                    "slot" => [
                        "Ring 2",
                    ],
                    "type" => "HM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=46046/bague-de-la-n%C3%A9buleuse",
                ],
                [
                    "id" => "40719",
                    "name" => "Bague de magie canalisée",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "NM",
                    "raid" => "Hors raid",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=40719/bague-de-magie-canalis%C3%A9e",
                ],
                [
                    "id" => "45326",
                    "name" => "Bague des Ases en platine",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45326/bague-des-ases-en-platine",
                ],
                [
                    "id" => "46048",
                    "name" => "Bague des lumières",
                    "slot" => [
                        "Ring 1",
                    ],
                    "type" => "HM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=46048/bague-des-lumi%C3%A8res",
                ],
                                [
                    "id" => "45257",
                    "name" => "Baguette en cristal de quartz",
                    "slot" => [
                        "Relic-Wand-Ranged",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "https://www.wowhead.com/wotlk/fr/item=45257/baguette-en-cristal-de-quartz",
                ],
                                [
                    "id" => "45450",
                    "name" => "Barrière nordique",
                    "slot" => [
                        "Offhand",
                    ],
                    "type" => "NM",
                    "raid" => "Ulduar",
                    "detail" => "",
                ],
            ];

            // // $itemsObjArray = [];
            // foreach ($itemsObjArray as $currentItem) {
            //     $itemObj = new Item();

            //     $itemObj->setId($currentItem['id']);
            //     $itemObj->setName($currentItem['name']);
            //     $itemObj->setType($currentItem['type']);
            //     $itemObj->setSlug($this->slugger->slug(mb_strtolower($currentItem['name'])));
            //     $itemObj->setDetail($currentItem['detail']);

            //     $raidObj = $this->getReference($currentItem["raid"]);
            //     $itemObj->setRaid($raidObj);

            //     // $slotObj = $this->getReference($currentItem["slot"]);
            //     // $itemObj->addSlot($slotObj);
            //     foreach ($currentItem["slot"] as $currentSlotName) {
            //         $currentSlotObj = $slotObjArray[md5($currentSlotName)];
            //         $itemObj->addSlot($currentSlotObj);
            //     };

            //     $itemsObjArray[md5($currentItem['name'])] = $itemObj;

            //     $manager->persist($itemObj);

            //     //* reference to link fixtures files
            //     $this->addReference($currentItem['name'], $itemObj);
            // }

        // ------------------------------- Players -------------------------------
            $playersObjArray = [

                [
                    "name" => "Arianhrod",
                    "class" => "Druide",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Atanea",
                    "class" => "Prêtre",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Demi",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Belzedar",
                    "class" => "Prêtre",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Bourla",
                    "class" => "Paladin",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Burgrogue",
                    "class" => "Voleur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Demi",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Camchoupette",
                    "class" => "Paladin",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Demi",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Cegar",
                    "class" => "Paladin",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Cheren",
                    "class" => "Chasseur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Chip",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Demi",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Chpok",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Demoralyse",
                    "class" => "Démoniste",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Demi",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Eckte",
                    "class" => "Paladin",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Elvidora",
                    "class" => "Chevalier de la mort",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Euphorus",
                    "class" => "Voleur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Farah",
                    "class" => "Chevalier de la mort",
                    "score" => "0",
                    "role" => "Tank",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Floriel",
                    "class" => "Druide",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Gazzole",
                    "class" => "Voleur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Grymn",
                    "class" => "Guerrier",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Gulliver",
                    "class" => "Démoniste",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Feyde",
                    "class" => "Démoniste",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Gwendydd",
                    "class" => "Druide",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Icekarr",
                    "class" => "Chaman",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Judgentix",
                    "class" => "Chaman",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Kamari",
                    "class" => "Chasseur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Kenym",
                    "class" => "Chevalier de la mort",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Kwaky",
                    "class" => "Démoniste",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Lady",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Limdul",
                    "class" => "Prêtre",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Lucamar",
                    "class" => "Druide",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Maxxam",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Mealyn",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Mjollnir",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Necrogirl",
                    "class" => "Démoniste",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Portish",
                    "class" => "Prêtre",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Pyrotesse",
                    "class" => "Guerrier",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Rim",
                    "class" => "Paladin",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Schaga",
                    "class" => "Chaman",
                    "score" => "0",
                    "role" => "Healer",
                    "rank" => "Sérieux",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Selena",
                    "class" => "Druide",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Demi",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Sha",
                    "class" => "Chevalier de la mort",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Skenz",
                    "class" => "Chaman",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Sunks",
                    "class" => "Voleur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Tanriel",
                    "class" => "Chasseur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Galopin",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Synadra",
                    "class" => "Chasseur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Tinduviel",
                    "class" => "Guerrier",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Ulmo",
                    "class" => "Voleur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Untardo",
                    "class" => "Chasseur",
                    "score" => "0",
                    "role" => "CAC",
                    "rank" => "Demi",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Vali",
                    "class" => "Paladin",
                    "score" => "0",
                    "role" => "Tank",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Vultris",
                    "class" => "Démoniste",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "0",
                ],

                [
                    "name" => "Xamena",
                    "class" => "Mage",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

                [
                    "name" => "Youyou",
                    "class" => "Druide",
                    "score" => "0",
                    "role" => "Caster",
                    "rank" => "Sérieux",
                    "is_actif" => "1",
                ],

            ];

            // $playersObjArray = [];
            foreach ($playersObjArray as $currentPlayer) {
                $playerObj = new Player();

                $playerObj->setName($currentPlayer['name']);
                $playerObj->setClass($currentPlayer['class']);
                $playerObj->setScore($currentPlayer['score']);
                $playerObj->setRank($currentPlayer['rank']);
                $playerObj->setIsActif($currentPlayer['is_actif']);

                $playerObj->setSlug($this->slugger->slug(mb_strtolower($currentPlayer['name'])));

                $roleObj = $this->getReference($currentPlayer["role"]);
                $playerObj->setRole($roleObj);

                $playersObjArray[md5($currentPlayer['name'])] = $playerObj;

                $manager->persist($playerObj);

                //* reference to link fixtures files
                $this->addReference($currentPlayer['name'], $playerObj);
            }

        // ------------------------------- Events -------------------------------
            $events = [
                [
                    "date" => "2023-01-22 20:45:00",
                    "log" => "https://classic.warcraftlogs.com/reports/WK2rnxcaMzARLf1H/#boss=-2&difficulty=0&wipes=2&view=rankings",
                    "raid" => [
                        "Ulduar",
                    ],
                ],
                [
                    "date" => "2023-01-23 20:45:00",
                    "log" => "https://classic.warcraftlogs.com/reports/RFKm4ZkDWX2zj96G/",
                    "raid" => [
                        "Ulduar",
                    ],
                ],
                [
                    "date" => "2023-01-25 20:45:00",
                    "log" => "https://classic.warcraftlogs.com/reports/4Y2QLPRrxGJVZ1mg/",
                    "raid" => [
                        "Ulduar",
                    ],
                ],
                [
                    "date" => "2023-01-29 20:45:00",
                    "log" => "https://classic.warcraftlogs.com/reports/mQ287XwLby6KJrHR/",
                    "raid" => [
                        "Ulduar",
                    ],
                ],
            ];

            foreach ($events as $currentEvent) {
                $eventObj = new Event();

                $eventObj->setDate(new DateTimeImmutable($currentEvent["date"]));
                $eventObj->setLog($currentEvent['log']);

                // $raidObj = $this->getReference($currentEvent["raid"]);
                // $eventObj->addRaid($raidObj);
                foreach ($currentEvent["raid"] as $currentRaidName) {
                    $currentEventObj = $raidsObjArray[md5($currentRaidName)];
                    $eventObj->addRaid($currentEventObj);
                };

                $manager->persist($eventObj);

                //* reference to link fixtures files
                $this->addReference($currentEvent['date'], $eventObj);
            }

        // ------------------------------- LootHistories -------------------------------
            // $lootHistories = [
            //     [
            //         "event" => "2023-01-22 20:45:00",
            //         "player" => "Lucamar",
            //         "item" => "Totem de croissance forestière",
            //     ],
            // ];

            // foreach ($lootHistories as $currentLoot) {
            //     $lootObj = new LootHistory();

            //     $eventObj = $this->getReference($currentLoot["event"]);
            //     $lootObj->setEvent($eventObj);

            //     $playerObj = $this->getReference($currentLoot["player"]);
            //     $lootObj->setPlayer($playerObj);

            //     $itemObj = $this->getReference($currentLoot["item"]);
            //     $lootObj->setItem($itemObj);

            //     $manager->persist($lootObj);
            // }
         
        // ------------------------------- Participations -------------------------------
            $participations = [
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Farah",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Vali",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Kenym",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Sha",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Elvidora",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Pyrotesse",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Tinduviel",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Gwendydd",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Youyou",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Arianhrod",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Rim",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Cegar",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Bourla",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Eckte",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Ulmo",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Synadra",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Lady",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Chip",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Mealyn",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Feyde",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Necrogirl",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Belzedar",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Limdul",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Portish",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Skenz",
                    "isBench" => 0,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Mjollnir",
                    "isBench" => 1,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Xamena",
                    "isBench" => 1,
                ],
                [
                    "event" => "2023-01-22 20:45:00",
                    "player" => "Icekarr",
                    "isBench" => 1,
                ],
            ];

            foreach ($participations as $currentParticipation) {
                $participationObj = new Participation();

                $eventObj = $this->getReference($currentParticipation["event"]);
                $participationObj->setEvent($eventObj);

                $playerObj = $this->getReference($currentParticipation["player"]);
                $participationObj->setPlayer($playerObj);

                $participationObj->setIsBench($currentParticipation['isBench']);

                $manager->persist($participationObj);
            }

            $manager->flush();
        }
}
