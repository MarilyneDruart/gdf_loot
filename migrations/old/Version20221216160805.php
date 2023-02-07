<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216160805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, slug VARCHAR(64) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slot_item (slot_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_C1328F8959E5119C (slot_id), INDEX IDX_C1328F89126F525E (item_id), PRIMARY KEY(slot_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slot_item ADD CONSTRAINT FK_C1328F8959E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_item ADD CONSTRAINT FK_C1328F89126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_item DROP FOREIGN KEY FK_9F1F905E126F525E');
        $this->addSql('ALTER TABLE location_item DROP FOREIGN KEY FK_9F1F905E64D218E');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE location_item (location_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_9F1F905E126F525E (item_id), INDEX IDX_9F1F905E64D218E (location_id), PRIMARY KEY(location_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE location_item ADD CONSTRAINT FK_9F1F905E126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_item ADD CONSTRAINT FK_9F1F905E64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slot_item DROP FOREIGN KEY FK_C1328F8959E5119C');
        $this->addSql('ALTER TABLE slot_item DROP FOREIGN KEY FK_C1328F89126F525E');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE slot_item');
    }
}
