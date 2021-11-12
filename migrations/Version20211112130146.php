<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211112130146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añadido relaciones y columnas a user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_city (user_id INTEGER NOT NULL, city_id INTEGER NOT NULL, PRIMARY KEY(user_id, city_id))');
        $this->addSql('CREATE INDEX IDX_57DA4EFDA76ED395 ON user_city (user_id)');
        $this->addSql('CREATE INDEX IDX_57DA4EFD8BAC62AF ON user_city (city_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, content, date_created FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, points_to_id INTEGER NOT NULL, content VARCHAR(4000) NOT NULL COLLATE BINARY, date_created DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CDBB5026F FOREIGN KEY (points_to_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, content, date_created) SELECT id, content, date_created FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CDBB5026F ON comment (points_to_id)');

        // Tienen que ser no nulas
        $this->addSql('ALTER TABLE user ADD COLUMN confirmation_code CLOB');
        $this->addSql('ALTER TABLE user ADD COLUMN confirmation_time DATETIME');
        $this->addSql('ALTER TABLE user ADD COLUMN created_time DATETIME');

        // Ahora quito los usuarios que he creado de prueba
        $this->addSql('DELETE FROM user WHERE confirmation_code IS NULL;');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_city');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526CDBB5026F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, content, date_created FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(4000) NOT NULL, date_created DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, content, date_created) SELECT id, content, date_created FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, name FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, name) SELECT id, email, roles, password, name FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
