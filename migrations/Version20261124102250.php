<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261124102250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt ADD statut_reservation VARCHAR(255) NOT NULL, CHANGE date_emprunt date_emprunt DATETIME DEFAULT NULL, CHANGE date_retour_prevu date_retour_prevu DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP statut_reservation, CHANGE date_emprunt date_emprunt DATETIME NOT NULL, CHANGE date_retour_prevu date_retour_prevu DATETIME NOT NULL');
    }
}
