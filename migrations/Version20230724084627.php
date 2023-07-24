<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724084627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, offer_id INT NOT NULL, status VARCHAR(100) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_A45BDDC191BD8781 (candidate_id), INDEX IDX_A45BDDC153C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, favorite_id INT DEFAULT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, phone VARCHAR(100) DEFAULT NULL, resume VARCHAR(150) DEFAULT NULL, introduction TEXT DEFAULT NULL, job_title VARCHAR(150) DEFAULT NULL, experience VARCHAR(100) DEFAULT NULL, picture VARCHAR(150) DEFAULT NULL, visible TINYINT(1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C8B28E44A76ED395 (user_id), INDEX IDX_C8B28E44AA17481D (favorite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidate_metadata (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, linkedin VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, portefolio VARCHAR(255) DEFAULT NULL, other VARCHAR(255) DEFAULT NULL, INDEX IDX_EE4A76C791BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, favorite_id INT DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, size VARCHAR(100) DEFAULT NULL, sector VARCHAR(150) DEFAULT NULL, presentation TEXT DEFAULT NULL, logo VARCHAR(150) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094FA76ED395 (user_id), INDEX IDX_4FBF094FAA17481D (favorite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, start_at DATETIME DEFAULT NULL, contract VARCHAR(150) NOT NULL, work_from_home VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, experience VARCHAR(150) NOT NULL, min_salary INT NOT NULL, max_salary INT DEFAULT NULL, location VARCHAR(255) NOT NULL, interview_process LONGTEXT NOT NULL, picture VARCHAR(255) DEFAULT NULL, number INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, archived TINYINT(1) NOT NULL, INDEX IDX_29D6873E979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_candidate (offer_id INT NOT NULL, candidate_id INT NOT NULL, INDEX IDX_6B77F38053C674EE (offer_id), INDEX IDX_6B77F38091BD8781 (candidate_id), PRIMARY KEY(offer_id, candidate_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_candidate (skill_id INT NOT NULL, candidate_id INT NOT NULL, INDEX IDX_9B43B5195585C142 (skill_id), INDEX IDX_9B43B51991BD8781 (candidate_id), PRIMARY KEY(skill_id, candidate_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_offer (skill_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CFE14025585C142 (skill_id), INDEX IDX_CFE140253C674EE (offer_id), PRIMARY KEY(skill_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, candidate_id INT DEFAULT NULL, company_id INT DEFAULT NULL, roles JSON NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_8D93D64991BD8781 (candidate_id), UNIQUE INDEX UNIQ_8D93D649979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC191BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC153C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44AA17481D FOREIGN KEY (favorite_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE candidate_metadata ADD CONSTRAINT FK_EE4A76C791BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FAA17481D FOREIGN KEY (favorite_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE offer_candidate ADD CONSTRAINT FK_6B77F38053C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_candidate ADD CONSTRAINT FK_6B77F38091BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_candidate ADD CONSTRAINT FK_9B43B5195585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_candidate ADD CONSTRAINT FK_9B43B51991BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_offer ADD CONSTRAINT FK_CFE14025585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_offer ADD CONSTRAINT FK_CFE140253C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64991BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC191BD8781');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC153C674EE');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44A76ED395');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44AA17481D');
        $this->addSql('ALTER TABLE candidate_metadata DROP FOREIGN KEY FK_EE4A76C791BD8781');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FAA17481D');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E979B1AD6');
        $this->addSql('ALTER TABLE offer_candidate DROP FOREIGN KEY FK_6B77F38053C674EE');
        $this->addSql('ALTER TABLE offer_candidate DROP FOREIGN KEY FK_6B77F38091BD8781');
        $this->addSql('ALTER TABLE skill_candidate DROP FOREIGN KEY FK_9B43B5195585C142');
        $this->addSql('ALTER TABLE skill_candidate DROP FOREIGN KEY FK_9B43B51991BD8781');
        $this->addSql('ALTER TABLE skill_offer DROP FOREIGN KEY FK_CFE14025585C142');
        $this->addSql('ALTER TABLE skill_offer DROP FOREIGN KEY FK_CFE140253C674EE');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64991BD8781');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE candidate_metadata');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_candidate');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_candidate');
        $this->addSql('DROP TABLE skill_offer');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
