<?php

namespace App\Controller\Back;

use App\Entity\Event;
use App\Entity\LootHistory;
use App\Entity\Participation;
use App\Form\EventType;
use App\Form\LootHistoryType;
use App\Form\ParticipationType;
use App\Repository\EventRepository;
use App\Repository\LootHistoryRepository;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ImportController extends AbstractController
{

    private $state_csv = false;
    // function __construct()
    // {
    //     parent::__construct("localhost", "MarAdminer", "Unnouveaumdp87", "csv");
    //     if ($this->connect_error) {
    //         echo "Fail to connect to Database : ". $this->connect_error;
    //     }
    // }

    /**
     * add lootHistory in event (id of event)
     *
     * @Route("event/{id<\d+>}/loothistory/add/csv", name="app_admin_event_lootHistory_create_csv", methods={"GET", "POST"})
     * @return Response
     */
    public function lootHistoryCreateCSV(EntityManagerInterface $em, Event $event, Request $request): Response
    {
        // $lootHistory = new LootHistory();
        // $lootHistory->setEvent($event);

        function import($file)
        {
            $first = false;
            $this->state_csv = false;
            $file = fopen($file, 'r');

            while ($row = fgetcsv($file)) {
                if (!$first) {
                    $first = true;
                } else {
                    var_dump($row);
                    $value = "'". implode("','", $row) ."'";
                    echo $value;
                    $q = "INSERT INTO loot_history (id,event_id,player_name,item_id) VALUES(". $value .")";
                    echo $q;

                    if ($this->query($q)) {
                        $this->state_csv = true;
                    } else {
                        $this->state_csv = false;
                        echo $this->error;
                    }
                }
            }

            if ($this->state_csv) {
                echo "Successfully Imported";
            } else {
                echo "Something went wrong";
            }
        }

        function export()
        {
            $this->state_csv = false;

            $q = 'SELECT t.id, t.event_id, t.player_name, t.item_id FROM loot_history as t';
            $run = $this->query($q);

            if ($run->num_rows > 0) {
                $fn = "csv_". uniqid() .".csv";
                $file = fopen("files/" . $fn, "w");

                while ($row = $run->fetch_array(MYSQLI_NUM)) {
                    // var_dump($row);

                    if (fputcsv($file, $row)) {
                        $this->state_csv = true;
                    } else {
                        $this->state_csv = false;
                        echo $this->error;
                    }
                }

                if ($this->state_csv) {
                    echo "Successfully Export";
                } else {
                    echo "Something went wrong";
                }
                fclose($file);
            } else {
                echo "No data found";
            }
        }
        return $this->render('back/lootHistory/_form_csv.html.twig', [
            'event' => $event,
        ]);
    }
}