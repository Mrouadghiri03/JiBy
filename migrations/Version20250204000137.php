<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204000137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_user ADD data_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE data_user ADD CONSTRAINT FK_36DC1DAB37F5A13C FOREIGN KEY (data_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_36DC1DAB37F5A13C ON data_user (data_id)');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP gmail, DROP adress, DROP phone, DROP age');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_user DROP FOREIGN KEY FK_36DC1DAB37F5A13C');
        $this->addSql('DROP INDEX UNIQ_36DC1DAB37F5A13C ON data_user');
        $this->addSql('ALTER TABLE data_user DROP data_id');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(50) DEFAULT NULL, ADD lastname VARCHAR(50) DEFAULT NULL, ADD gmail VARCHAR(76) DEFAULT NULL, ADD adress VARCHAR(100) DEFAULT NULL, ADD phone VARCHAR(30) DEFAULT NULL, ADD age INT DEFAULT NULL');
    }
}
