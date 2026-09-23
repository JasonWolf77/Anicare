<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260923160512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
    // 1. Ajoute la colonne
    //$this->addSql('ALTER TABLE animal ADD identification_data VARCHAR(30) NOT NULL');

    // 2. Génère un numéro de tatouage temporaire valide pour chaque ligne existante
    $this->addSql("UPDATE animal SET identification_data = CONCAT('tatouage:TMP', LPAD(id, 3, '0')) WHERE identification_data = ''");

    // 3. Applique la contrainte d'unicité
    $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231F44661DB7 ON animal (identification_data)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_6AAB231F44661DB7 ON animal');
        $this->addSql('ALTER TABLE animal DROP identification_data');
    }
}
