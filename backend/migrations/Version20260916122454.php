<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260916122454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY `FK_6AAB231FB2A1D860`');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('ALTER TABLE animal CHANGE species_id specie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD5436AB7 FOREIGN KEY (specie_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FD5436AB7 ON animal (specie_id)');
        $this->addSql('ALTER TABLE race ADD specie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAFD5436AB7 FOREIGN KEY (specie_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAFD5436AB7 ON race (specie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD5436AB7');
        $this->addSql('DROP INDEX IDX_6AAB231FD5436AB7 ON animal');
        $this->addSql('ALTER TABLE animal CHANGE specie_id species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT `FK_6AAB231FB2A1D860` FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAFD5436AB7');
        $this->addSql('DROP INDEX IDX_DA6FBBAFD5436AB7 ON race');
        $this->addSql('ALTER TABLE race DROP specie_id');
    }
}
