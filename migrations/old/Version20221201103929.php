<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201103929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, slug VARCHAR(64) NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_item (location_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_9F1F905E64D218E (location_id), INDEX IDX_9F1F905E126F525E (item_id), PRIMARY KEY(location_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_item ADD CONSTRAINT FK_9F1F905E64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_item ADD CONSTRAINT FK_9F1F905E126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item DROP location');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_item DROP FOREIGN KEY FK_9F1F905E64D218E');
        $this->addSql('ALTER TABLE location_item DROP FOREIGN KEY FK_9F1F905E126F525E');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_item');
        $this->addSql('ALTER TABLE item ADD location VARCHAR(64) NOT NULL');
    }
}
