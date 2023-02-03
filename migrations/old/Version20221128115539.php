<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128115539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, log VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_raid (event_id INT NOT NULL, raid_id INT NOT NULL, INDEX IDX_484C2F1871F7E88B (event_id), INDEX IDX_484C2F189C55ABC9 (raid_id), PRIMARY KEY(event_id, raid_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_player (event_id INT NOT NULL, player_id INT NOT NULL, is_bench TINYINT(1) NULL, INDEX IDX_AA800D3771F7E88B (event_id), INDEX IDX_AA800D3799E6F5DF (player_id), PRIMARY KEY(event_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_item (event_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_D069B571F7E88B (event_id), INDEX IDX_D069B5126F525E (item_id), PRIMARY KEY(event_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, raid_id INT NOT NULL, name VARCHAR(64) NOT NULL, location VARCHAR(64) NOT NULL, type VARCHAR(10) NOT NULL, slug VARCHAR(64) NOT NULL, INDEX IDX_1F1B251E9C55ABC9 (raid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_role (item_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9F59CE91126F525E (item_id), INDEX IDX_9F59CE91D60322AC (role_id), PRIMARY KEY(item_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_player (item_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_1EE00FAA126F525E (item_id), INDEX IDX_1EE00FAA99E6F5DF (player_id), PRIMARY KEY(item_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, name VARCHAR(64) NOT NULL, class VARCHAR(30) NOT NULL, score DOUBLE PRECISION NOT NULL, rank VARCHAR(30) NOT NULL, is_actif TINYINT(1) NOT NULL, slug VARCHAR(64) NOT NULL, INDEX IDX_98197A65D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, slug VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_player (raid_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_ABCBEEB69C55ABC9 (raid_id), INDEX IDX_ABCBEEB699E6F5DF (player_id), PRIMARY KEY(raid_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, slug VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_raid ADD CONSTRAINT FK_484C2F1871F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_raid ADD CONSTRAINT FK_484C2F189C55ABC9 FOREIGN KEY (raid_id) REFERENCES raid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_player ADD CONSTRAINT FK_AA800D3771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_player ADD CONSTRAINT FK_AA800D3799E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_item ADD CONSTRAINT FK_D069B571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_item ADD CONSTRAINT FK_D069B5126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E9C55ABC9 FOREIGN KEY (raid_id) REFERENCES raid (id)');
        $this->addSql('ALTER TABLE item_role ADD CONSTRAINT FK_9F59CE91126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_role ADD CONSTRAINT FK_9F59CE91D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_player ADD CONSTRAINT FK_1EE00FAA126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_player ADD CONSTRAINT FK_1EE00FAA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE raid_player ADD CONSTRAINT FK_ABCBEEB69C55ABC9 FOREIGN KEY (raid_id) REFERENCES raid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_player ADD CONSTRAINT FK_ABCBEEB699E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_raid DROP FOREIGN KEY FK_484C2F1871F7E88B');
        $this->addSql('ALTER TABLE event_raid DROP FOREIGN KEY FK_484C2F189C55ABC9');
        $this->addSql('ALTER TABLE event_player DROP FOREIGN KEY FK_AA800D3771F7E88B');
        $this->addSql('ALTER TABLE event_player DROP FOREIGN KEY FK_AA800D3799E6F5DF');
        $this->addSql('ALTER TABLE event_item DROP FOREIGN KEY FK_D069B571F7E88B');
        $this->addSql('ALTER TABLE event_item DROP FOREIGN KEY FK_D069B5126F525E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E9C55ABC9');
        $this->addSql('ALTER TABLE item_role DROP FOREIGN KEY FK_9F59CE91126F525E');
        $this->addSql('ALTER TABLE item_role DROP FOREIGN KEY FK_9F59CE91D60322AC');
        $this->addSql('ALTER TABLE item_player DROP FOREIGN KEY FK_1EE00FAA126F525E');
        $this->addSql('ALTER TABLE item_player DROP FOREIGN KEY FK_1EE00FAA99E6F5DF');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65D60322AC');
        $this->addSql('ALTER TABLE raid_player DROP FOREIGN KEY FK_ABCBEEB69C55ABC9');
        $this->addSql('ALTER TABLE raid_player DROP FOREIGN KEY FK_ABCBEEB699E6F5DF');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_raid');
        $this->addSql('DROP TABLE event_player');
        $this->addSql('DROP TABLE event_item');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_role');
        $this->addSql('DROP TABLE item_player');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE raid');
        $this->addSql('DROP TABLE raid_player');
        $this->addSql('DROP TABLE role');
    }
}
