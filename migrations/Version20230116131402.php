<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116131402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_slot (item_id INT NOT NULL, slot_id INT NOT NULL, INDEX IDX_643E649C126F525E (item_id), INDEX IDX_643E649C59E5119C (slot_id), PRIMARY KEY(item_id, slot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_slot ADD CONSTRAINT FK_643E649C126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_slot ADD CONSTRAINT FK_643E649C59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_item DROP FOREIGN KEY FK_C1328F89126F525E');
        $this->addSql('ALTER TABLE slot_item DROP FOREIGN KEY FK_C1328F8959E5119C');
        $this->addSql('DROP TABLE slot_item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slot_item (slot_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_C1328F8959E5119C (slot_id), INDEX IDX_C1328F89126F525E (item_id), PRIMARY KEY(slot_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE slot_item ADD CONSTRAINT FK_C1328F89126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_item ADD CONSTRAINT FK_C1328F8959E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_slot DROP FOREIGN KEY FK_643E649C126F525E');
        $this->addSql('ALTER TABLE item_slot DROP FOREIGN KEY FK_643E649C59E5119C');
        $this->addSql('DROP TABLE item_slot');
    }
}
