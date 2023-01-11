<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111104749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loot_history (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, player_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2ED2066371F7E88B (event_id), UNIQUE INDEX UNIQ_2ED2066399E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loot_history_item (loot_history_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_3CCDEF361257A419 (loot_history_id), INDEX IDX_3CCDEF36126F525E (item_id), PRIMARY KEY(loot_history_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loot_history ADD CONSTRAINT FK_2ED2066371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE loot_history ADD CONSTRAINT FK_2ED2066399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE loot_history_item ADD CONSTRAINT FK_3CCDEF361257A419 FOREIGN KEY (loot_history_id) REFERENCES loot_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loot_history_item ADD CONSTRAINT FK_3CCDEF36126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player CHANGE class class enum(\'Chaman\', \'Chasseur\', \'Chevalier de la mort\', \'Démoniste\', \'Druide\', \'Guerrier\', \'Mage\', \'Paladin\', \'Prêtre\', \'Voleur\'), CHANGE rank rank enum(\'Demi\', \'Galopin\', \'Sérieux\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loot_history DROP FOREIGN KEY FK_2ED2066371F7E88B');
        $this->addSql('ALTER TABLE loot_history DROP FOREIGN KEY FK_2ED2066399E6F5DF');
        $this->addSql('ALTER TABLE loot_history_item DROP FOREIGN KEY FK_3CCDEF361257A419');
        $this->addSql('ALTER TABLE loot_history_item DROP FOREIGN KEY FK_3CCDEF36126F525E');
        $this->addSql('DROP TABLE loot_history');
        $this->addSql('DROP TABLE loot_history_item');
        $this->addSql('ALTER TABLE player CHANGE class class VARCHAR(255) DEFAULT NULL, CHANGE rank rank VARCHAR(255) DEFAULT NULL');
    }
}
