# Requêtes
## Requete 1
```sql
SELECT item.id, raid_id, raid.name AS raid, item.name AS item, item.type, player_id, player.name AS joueur, role_id,  class, rank, event_id, date 
FROM item 
JOIN item_player ON item.id = item_player.item_id 
JOIN player ON item_player.player_id = player.id 
JOIN event_item ON event_item.item_id = item.id
JOIN event ON event.id = event_item.event_id
JOIN raid ON raid.id = item.raid_id
```

## INSERT Event_player_item in Loothistory avec les données event_id, player_name et item_d
Je dois récupérer le player_id grace au player_name
```sql
INSERT INTO `loot_history` (`event_id`, `player_id`, `item_id`) 
VALUES ('4', (SELECT id FROM player p WHERE p.name = 'Lucamar'), '40074')
```

## Upload des données à partir d'un fichier CSV
Test avec la doc suivante https://analyse-innovation-solution.fr/publication/fr/sql/insert-into
```sql
/* la commande LOAD DATA INFILE vise à charger des ensembles de lignes directement depuis un jeu de données (aussi appelée dataset)
 sans avoir besoin de créer chaque requête manuellement. */
LOAD DATA INFILE '/monfichier.csv/'

/* syntaxe à redéfinir INTO TABLE et VALUES pour préciser les champs et la jointure */
INTO TABLE `loot_history` (`event_id`, `player_id`, `item_id`) 
VALUES ('4', (SELECT id FROM player p WHERE p.name = 'Belzedar'), '40074')

/* FIELDS TERMINATED BY permet de définir que chaque champ est séparé par une virgule.*/
FIELDS TERMINATED BY ' ,'

/* le paramètre IGNORE X LINES qui sert à déclaré que le fichier CSV dispose d'un en tête et que celui-ci doit être ignoré par la commande lors du traitement du lot des données.*/
IGNORE 1 LINES ;
```

## SELECT Count Items  NM / HM / Contested du LootHistory d'un player
Je veux récuperer le total des items dont le type est NM pour le player 13

### Somme de tous les items du player 13 dont le type est NM
#### Requête SQL
```sql
SELECT count('NM')
FROM loot_history
JOIN item
ON loot_history.item_id = item.id
WHERE player_id = 13 AND item.type= 'NM';
```

#### Requête DQL
```php
    public function findNbItemNM(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT COUNT('NM') AS sumItemsNM 
            FROM App\Entity\lootHistory lh 
            JOIN App\Entity\item i
            WITH lh.item = i.id
            WHERE lh.player = 13 AND i.type = 'NM'
            "
        );

        return $query->getResult();
    }
```