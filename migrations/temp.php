<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111154943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // Sqlite no nos permite añadir columnas no nulas en una tabla ya creada
        // Por ello, tendremos que primero añadirlas normal -> ponerles un valor -> pasarlas a not null
        // 1. Las añades normal: ALTER TABLE user ADD COLUMN user_name VARCHAR(64);
        // 2. Les pones un valor: UPDATE tabla SET columna = ... WHERE columna IS NULL;
        // 3. La pasas a NOT NULL: ALTER TABLE table_name ALTER COLUMN col_name data_type NOT NULL;

        // Otra cosa: Ejecuta  "composer dump-autoload" cuando doctrine se ponga de chulo guardando entidades 
        // que no quieres en su cache

        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526CDBB5026F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, points_to_id, user_id, date, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, points_to_id INTEGER NOT NULL, user_id INTEGER NOT NULL, date DATETIME NOT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_9474526CDBB5026F FOREIGN KEY (points_to_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, points_to_id, user_id, date, content) SELECT id, points_to_id, user_id, date, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CDBB5026F ON comment (points_to_id)');

        // Añadimos nuevas columnas
        $this->addSql('ALTER TABLE user ADD COLUMN password VARCHAR(255)');
        $this->addSql('ALTER TABLE user ADD COLUMN email VARCHAR(128)');
        $this->addSql('ALTER TABLE user ADD COLUMN confirmation_code CLOB');
        $this->addSql('ALTER TABLE user ADD COLUMN confirmation_time DATETIME');
        $this->addSql('ALTER TABLE user ADD COLUMN created_time DATETIME');

        // Rellenamos los datos con vacios (Como estaba la tabla user vacia esto me lo salto)
        // $this->addSql('ALTER TABLE table_name ALTER COLUMN col_name data_type NOT NULL');
        $this->addSql('DROP INDEX IDX_57DA4EFD8BAC62AF');
        $this->addSql('DROP INDEX IDX_57DA4EFDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_city AS SELECT user_id, city_id FROM user_city');
        $this->addSql('DROP TABLE user_city');
        $this->addSql('CREATE TABLE user_city (user_id INTEGER NOT NULL, city_id INTEGER NOT NULL, PRIMARY KEY(user_id, city_id), CONSTRAINT FK_57DA4EFDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_57DA4EFD8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_city (user_id, city_id) SELECT user_id, city_id FROM __temp__user_city');
        $this->addSql('DROP TABLE __temp__user_city');
        $this->addSql('CREATE INDEX IDX_57DA4EFD8BAC62AF ON user_city (city_id)');
        $this->addSql('CREATE INDEX IDX_57DA4EFDA76ED395 ON user_city (user_id)');
        $this->addSql('DROP INDEX IDX_CC794C66F8697D13');
        $this->addSql('DROP INDEX IDX_CC794C66A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_comment AS SELECT user_id, comment_id FROM user_comment');
        $this->addSql('DROP TABLE user_comment');
        $this->addSql('CREATE TABLE user_comment (user_id INTEGER NOT NULL, comment_id INTEGER NOT NULL, PRIMARY KEY(user_id, comment_id), CONSTRAINT FK_CC794C66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CC794C66F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_comment (user_id, comment_id) SELECT user_id, comment_id FROM __temp__user_comment');
        $this->addSql('DROP TABLE __temp__user_comment');
        $this->addSql('CREATE INDEX IDX_CC794C66F8697D13 ON user_comment (comment_id)');
        $this->addSql('CREATE INDEX IDX_CC794C66A76ED395 ON user_comment (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526CDBB5026F');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, points_to_id, user_id, date, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, points_to_id INTEGER NOT NULL, user_id INTEGER NOT NULL, date DATETIME NOT NULL, content VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO comment (id, points_to_id, user_id, date, content) SELECT id, points_to_id, user_id, date, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CDBB5026F ON comment (points_to_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, name FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, name) SELECT id, name FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('DROP INDEX IDX_57DA4EFDA76ED395');
        $this->addSql('DROP INDEX IDX_57DA4EFD8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_city AS SELECT user_id, city_id FROM user_city');
        $this->addSql('DROP TABLE user_city');
        $this->addSql('CREATE TABLE user_city (user_id INTEGER NOT NULL, city_id INTEGER NOT NULL, PRIMARY KEY(user_id, city_id))');
        $this->addSql('INSERT INTO user_city (user_id, city_id) SELECT user_id, city_id FROM __temp__user_city');
        $this->addSql('DROP TABLE __temp__user_city');
        $this->addSql('CREATE INDEX IDX_57DA4EFDA76ED395 ON user_city (user_id)');
        $this->addSql('CREATE INDEX IDX_57DA4EFD8BAC62AF ON user_city (city_id)');
        $this->addSql('DROP INDEX IDX_CC794C66A76ED395');
        $this->addSql('DROP INDEX IDX_CC794C66F8697D13');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_comment AS SELECT user_id, comment_id FROM user_comment');
        $this->addSql('DROP TABLE user_comment');
        $this->addSql('CREATE TABLE user_comment (user_id INTEGER NOT NULL, comment_id INTEGER NOT NULL, PRIMARY KEY(user_id, comment_id))');
        $this->addSql('INSERT INTO user_comment (user_id, comment_id) SELECT user_id, comment_id FROM __temp__user_comment');
        $this->addSql('DROP TABLE __temp__user_comment');
        $this->addSql('CREATE INDEX IDX_CC794C66A76ED395 ON user_comment (user_id)');
        $this->addSql('CREATE INDEX IDX_CC794C66F8697D13 ON user_comment (comment_id)');
    }
}
