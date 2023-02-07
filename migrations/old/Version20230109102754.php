<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109102754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loot_history (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, player_id INT DEFAULT NULL, item_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2ED2066371F7E88B (event_id), UNIQUE INDEX UNIQ_2ED2066399E6F5DF (player_id), INDEX IDX_2ED20663126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loot_history ADD CONSTRAINT FK_2ED2066371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE loot_history ADD CONSTRAINT FK_2ED2066399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE loot_history ADD CONSTRAINT FK_2ED20663126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE event_player DROP FOREIGN KEY FK_AA800D3771F7E88B');
        $this->addSql('ALTER TABLE event_player DROP FOREIGN KEY FK_AA800D3799E6F5DF');
        $this->addSql('ALTER TABLE item_player DROP FOREIGN KEY FK_1EE00FAA99E6F5DF');
        $this->addSql('ALTER TABLE item_player DROP FOREIGN KEY FK_1EE00FAA126F525E');
        $this->addSql('ALTER TABLE item_role DROP FOREIGN KEY FK_9F59CE91126F525E');
        $this->addSql('ALTER TABLE item_role DROP FOREIGN KEY FK_9F59CE91D60322AC');
        $this->addSql('ALTER TABLE raid_player DROP FOREIGN KEY FK_ABCBEEB699E6F5DF');
        $this->addSql('ALTER TABLE raid_player DROP FOREIGN KEY FK_ABCBEEB69C55ABC9');
        $this->addSql('DROP TABLE event_player');
        $this->addSql('DROP TABLE item_player');
        $this->addSql('DROP TABLE item_role');
        $this->addSql('DROP TABLE raid_player');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_player (event_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_AA800D3771F7E88B (event_id), INDEX IDX_AA800D3799E6F5DF (player_id), PRIMARY KEY(event_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE item_player (item_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_1EE00FAA126F525E (item_id), INDEX IDX_1EE00FAA99E6F5DF (player_id), PRIMARY KEY(item_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE item_role (item_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9F59CE91126F525E (item_id), INDEX IDX_9F59CE91D60322AC (role_id), PRIMARY KEY(item_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE raid_player (raid_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_ABCBEEB69C55ABC9 (raid_id), INDEX IDX_ABCBEEB699E6F5DF (player_id), PRIMARY KEY(raid_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event_player ADD CONSTRAINT FK_AA800D3771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_player ADD CONSTRAINT FK_AA800D3799E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_player ADD CONSTRAINT FK_1EE00FAA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_player ADD CONSTRAINT FK_1EE00FAA126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_role ADD CONSTRAINT FK_9F59CE91126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_role ADD CONSTRAINT FK_9F59CE91D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_player ADD CONSTRAINT FK_ABCBEEB699E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_player ADD CONSTRAINT FK_ABCBEEB69C55ABC9 FOREIGN KEY (raid_id) REFERENCES raid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loot_history DROP FOREIGN KEY FK_2ED2066371F7E88B');
        $this->addSql('ALTER TABLE loot_history DROP FOREIGN KEY FK_2ED2066399E6F5DF');
        $this->addSql('ALTER TABLE loot_history DROP FOREIGN KEY FK_2ED20663126F525E');
        $this->addSql('DROP TABLE loot_history');
    }
}
