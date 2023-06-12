<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612133444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP INDEX UNIQ_A45BDDC153C674EE, ADD INDEX IDX_A45BDDC153C674EE (offer_id)');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1A76ED395');
        $this->addSql('DROP INDEX UNIQ_A45BDDC1A76ED395 ON application');
        $this->addSql('ALTER TABLE application CHANGE user_id candidate_id INT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC191BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC191BD8781 ON application (candidate_id)');
        $this->addSql('ALTER TABLE candidate ADD visible TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE offer ADD salary_min INT NOT NULL, ADD salary_max INT NOT NULL, DROP salary');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP INDEX IDX_A45BDDC153C674EE, ADD UNIQUE INDEX UNIQ_A45BDDC153C674EE (offer_id)');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC191BD8781');
        $this->addSql('DROP INDEX IDX_A45BDDC191BD8781 ON application');
        $this->addSql('ALTER TABLE application CHANGE candidate_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES candidate (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC1A76ED395 ON application (user_id)');
        $this->addSql('ALTER TABLE candidate DROP visible');
        $this->addSql('ALTER TABLE offer ADD salary INT DEFAULT NULL, DROP salary_min, DROP salary_max');
    }
}
