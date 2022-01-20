<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * 
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.10/reference/inheritance-mapping.html
 * 
 * para crear supertipos: tabla Entity.
 * 
 * Yo usaria Class Table Inheritance
 * 
 *  Mejor a la hora de diseñar
 * 
 * Si me cargo un subtipo no me influye en ningun aspecto
 *  
 *  Igualmente Single Table es mas eficiente
 * 
 *      Tampoco es pa tanto (0.5 ms como mucho para mi caso de uso)
 * 
 */
final class Version20211228141206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, iso_code VARCHAR(64) NOT NULL)');
        $this->addSql('CREATE TABLE country_country_data (country_id INTEGER NOT NULL, country_data_id INTEGER NOT NULL, PRIMARY KEY(country_id, country_data_id))');
        $this->addSql('CREATE INDEX IDX_2663F495F92F3E70 ON country_country_data (country_id)');
        $this->addSql('CREATE INDEX IDX_2663F495FEB9F951 ON country_country_data (country_data_id)');
        $this->addSql('CREATE TABLE country_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, json_data CLOB NOT NULL --(DC2Type:json)
        , data_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE country_country_data');
        $this->addSql('DROP TABLE country_data');
    }
}
