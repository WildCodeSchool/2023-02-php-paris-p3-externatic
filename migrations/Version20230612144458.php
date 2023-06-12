<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612144458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application CHANGE application_date application_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE candidate CHANGE phone phone VARCHAR(100) DEFAULT NULL, CHANGE introduction introduction TEXT NOT NULL, CHANGE picture picture VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE company CHANGE presentation presentation TEXT NOT NULL, CHANGE sales_revenue sales_revenue INT DEFAULT NULL, CHANGE picture logo VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE offer ADD creation_date DATETIME NOT NULL, ADD starting_date DATETIME NOT NULL, ADD interview_process LONGTEXT NOT NULL, ADD picture VARCHAR(255) DEFAULT NULL, DROP add_date, DROP planed_at, CHANGE location location VARCHAR(255) NOT NULL, CHANGE salary_max salary_max INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application CHANGE application_date application_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE company CHANGE presentation presentation LONGTEXT NOT NULL, CHANGE sales_revenue sales_revenue INT NOT NULL, CHANGE logo picture VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE candidate CHANGE phone phone VARCHAR(100) NOT NULL, CHANGE introduction introduction LONGTEXT NOT NULL, CHANGE picture picture VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE offer ADD add_date DATETIME NOT NULL, ADD planed_at DATETIME NOT NULL, DROP creation_date, DROP starting_date, DROP interview_process, DROP picture, CHANGE salary_max salary_max INT NOT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL');
    }
}
