<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260916105146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, species_id INT DEFAULT NULL, INDEX IDX_DA6FBBAFB2A1D860 (species_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAFB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal ADD species_id INT DEFAULT NULL, ADD race_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F6E59D40D ON animal (race_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAFB2A1D860');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE species');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231F6E59D40D ON animal');
        $this->addSql('ALTER TABLE animal DROP species_id, DROP race_id');
    }
}
