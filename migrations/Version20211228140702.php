<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228140702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Dropeamos las tablas de country y countryData porque voy a cambiar todo';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE country_data');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, country_data_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, iso_code VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('CREATE INDEX IDX_5373C966FEB9F951 ON country (country_data_id)');
        $this->addSql('CREATE TABLE country_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, json_data CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        )');
    }
}
