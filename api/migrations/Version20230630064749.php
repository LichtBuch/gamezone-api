<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630064749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C12B36786B ON category (title)');
        $this->addSql('CREATE TABLE category_game (category_id INT NOT NULL, game_id INT NOT NULL, PRIMARY KEY(category_id, game_id))');
        $this->addSql('CREATE INDEX IDX_A8B04BCB12469DE2 ON category_game (category_id)');
        $this->addSql('CREATE INDEX IDX_A8B04BCBE48FD905 ON category_game (game_id)');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_game DROP CONSTRAINT FK_A8B04BCB12469DE2');
        $this->addSql('ALTER TABLE category_game DROP CONSTRAINT FK_A8B04BCBE48FD905');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_game');
    }
}
