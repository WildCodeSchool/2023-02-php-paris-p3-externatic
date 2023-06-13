<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613123710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_candidate (offer_id INT NOT NULL, candidate_id INT NOT NULL, INDEX IDX_6B77F38053C674EE (offer_id), INDEX IDX_6B77F38091BD8781 (candidate_id), PRIMARY KEY(offer_id, candidate_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer_candidate ADD CONSTRAINT FK_6B77F38053C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_candidate ADD CONSTRAINT FK_6B77F38091BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application DROP favorite, CHANGE application_date created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE candidate ADD favorite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44AA17481D FOREIGN KEY (favorite_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_C8B28E44AA17481D ON candidate (favorite_id)');
        $this->addSql('ALTER TABLE company ADD favorite_id INT DEFAULT NULL, CHANGE creation_year creation_year DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FAA17481D FOREIGN KEY (favorite_id) REFERENCES candidate (id)');
        $this->addSql('CREATE INDEX IDX_4FBF094FAA17481D ON company (favorite_id)');
        $this->addSql('ALTER TABLE offer ADD created_at DATETIME NOT NULL, ADD start_at DATETIME NOT NULL, DROP creation_date, DROP starting_date, CHANGE salary_min min_salary INT NOT NULL, CHANGE salary_max max_salary INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_candidate DROP FOREIGN KEY FK_6B77F38053C674EE');
        $this->addSql('ALTER TABLE offer_candidate DROP FOREIGN KEY FK_6B77F38091BD8781');
        $this->addSql('DROP TABLE offer_candidate');
        $this->addSql('ALTER TABLE application ADD favorite TINYINT(1) NOT NULL, CHANGE created_at application_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44AA17481D');
        $this->addSql('DROP INDEX IDX_C8B28E44AA17481D ON candidate');
        $this->addSql('ALTER TABLE candidate DROP favorite_id');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FAA17481D');
        $this->addSql('DROP INDEX IDX_4FBF094FAA17481D ON company');
        $this->addSql('ALTER TABLE company DROP favorite_id, CHANGE creation_year creation_year DATE NOT NULL');
        $this->addSql('ALTER TABLE offer ADD creation_date DATETIME NOT NULL, ADD starting_date DATETIME NOT NULL, DROP created_at, DROP start_at, CHANGE min_salary salary_min INT NOT NULL, CHANGE max_salary salary_max INT DEFAULT NULL');
    }
}
