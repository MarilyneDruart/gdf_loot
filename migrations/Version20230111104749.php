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
        $this->addSql('ALTER TABLE player CHANGE class class enum(\'Chaman\', \'Chasseur\', \'Chevalier de la mort\', \'Démoniste\', \'Druide\', \'Guerrier\', \'Mage\', \'Paladin\', \'Prêtre\', \'Voleur\'), CHANGE rank rank enum(\'Demi\', \'Galopin\', \'Sérieux\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player CHANGE class class VARCHAR(255) DEFAULT NULL, CHANGE rank rank VARCHAR(255) DEFAULT NULL');
    }
}
