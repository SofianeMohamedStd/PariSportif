<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211090009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, name_bet VARCHAR(255) NOT NULL, cote INT NOT NULL, date_bet_limit DATETIME NOT NULL, result_bet TINYINT(1) DEFAULT NULL, INDEX IDX_FBF0EC9BFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bet_id INT DEFAULT NULL, amount_bet_date DATETIME NOT NULL, amount_bet INT DEFAULT NULL, gain_possible INT DEFAULT NULL, INDEX IDX_A8450575A76ED395 (user_id), INDEX IDX_A8450575D871DC26 (bet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, INDEX IDX_B50A2CB1AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_user (id INT AUTO_INCREMENT NOT NULL, brochure_filename VARCHAR(255) NOT NULL, is_valid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, evenement_sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, contry VARCHAR(255) NOT NULL, INDEX IDX_2449BA15AC78BCF8 (sport_id), INDEX IDX_2449BA15231E2710 (evenement_sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_sport (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, competionn_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, begin_date DATETIME NOT NULL, event_place VARCHAR(255) NOT NULL, INDEX IDX_892F432AAC78BCF8 (sport_id), INDEX IDX_892F432A361BE7CA (competionn_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueurs (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F0FD889D6D861B89 (equipe_id), INDEX IDX_F0FD889DAC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nb_teams INT NOT NULL, nb_players INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, document_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, birth_date DATETIME NOT NULL, street VARCHAR(255) NOT NULL, street_number VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(5) NOT NULL, city VARCHAR(180) NOT NULL, phone VARCHAR(255) NOT NULL, create_date DATETIME NOT NULL, user_validation TINYINT(1) NOT NULL, user_verified TINYINT(1) NOT NULL, user_validation_date DATETIME DEFAULT NULL, user_suspended TINYINT(1) NOT NULL, user_suspended_date DATETIME DEFAULT NULL, user_deleted TINYINT(1) NOT NULL, user_deleted_date DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649444F97DD (phone), UNIQUE INDEX UNIQ_8D93D649712520F3 (wallet_id), UNIQUE INDEX UNIQ_8D93D649C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, credit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement_sport (id)');
        $this->addSql('ALTER TABLE bet_user ADD CONSTRAINT FK_A8450575A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bet_user ADD CONSTRAINT FK_A8450575D871DC26 FOREIGN KEY (bet_id) REFERENCES bet (id)');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15231E2710 FOREIGN KEY (evenement_sport_id) REFERENCES evenement_sport (id)');
        $this->addSql('ALTER TABLE evenement_sport ADD CONSTRAINT FK_892F432AAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE evenement_sport ADD CONSTRAINT FK_892F432A361BE7CA FOREIGN KEY (competionn_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889D6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889DAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C33F7837 FOREIGN KEY (document_id) REFERENCES document_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_user DROP FOREIGN KEY FK_A8450575D871DC26');
        $this->addSql('ALTER TABLE evenement_sport DROP FOREIGN KEY FK_892F432A361BE7CA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C33F7837');
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889D6D861B89');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BFD02F13');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15231E2710');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1AC78BCF8');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15AC78BCF8');
        $this->addSql('ALTER TABLE evenement_sport DROP FOREIGN KEY FK_892F432AAC78BCF8');
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889DAC78BCF8');
        $this->addSql('ALTER TABLE bet_user DROP FOREIGN KEY FK_A8450575A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649712520F3');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE bet_user');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE document_user');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE evenement_sport');
        $this->addSql('DROP TABLE joueurs');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wallet');
    }
}
