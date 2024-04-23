<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422141307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, duel_id INT NOT NULL, fighter_id INT NOT NULL, bet_value DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_FBF0EC9BA76ED395 (user_id), INDEX IDX_FBF0EC9B58875E (duel_id), INDEX IDX_FBF0EC9B34934341 (fighter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE duel (id INT AUTO_INCREMENT NOT NULL, fighter_1_id INT NOT NULL, fighter_2_id INT NOT NULL, date DATETIME NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_9BB4A7629F091091 (fighter_1_id), INDEX IDX_9BB4A7628DBCBF7F (fighter_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fighter (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, pseudo VARCHAR(50) NOT NULL, level INT NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, pseudo VARCHAR(50) NOT NULL, wallet DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B58875E FOREIGN KEY (duel_id) REFERENCES duel (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B34934341 FOREIGN KEY (fighter_id) REFERENCES fighter (id)');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A7629F091091 FOREIGN KEY (fighter_1_id) REFERENCES fighter (id)');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A7628DBCBF7F FOREIGN KEY (fighter_2_id) REFERENCES fighter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BA76ED395');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B58875E');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B34934341');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A7629F091091');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A7628DBCBF7F');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE duel');
        $this->addSql('DROP TABLE fighter');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
