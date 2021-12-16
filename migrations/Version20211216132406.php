<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216132406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Quitamos City y Comment para ahora hacer una db bien';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE user_city');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, id_iso VARCHAR(20) NOT NULL COLLATE BINARY, json_data CLOB DEFAULT NULL COLLATE BINARY, date_added DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, points_to_id INTEGER NOT NULL, content VARCHAR(4000) NOT NULL COLLATE BINARY, date_created DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CDBB5026F ON comment (points_to_id)');
        $this->addSql('CREATE TABLE user_city (user_id INTEGER NOT NULL, city_id INTEGER NOT NULL, PRIMARY KEY(user_id, city_id))');
        $this->addSql('CREATE INDEX IDX_57DA4EFDA76ED395 ON user_city (user_id)');
        $this->addSql('CREATE INDEX IDX_57DA4EFD8BAC62AF ON user_city (city_id)');
    }
}
