<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801234436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A0EF1B80');
        $this->addSql('DROP INDEX IDX_4C62E638A0EF1B80 ON contact');
        $this->addSql('ALTER TABLE contact CHANGE car_id_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638C3C6F69F ON contact (car_id)');
        $this->addSql('ALTER TABLE photos CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE services CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE testimonials CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638C3C6F69F');
        $this->addSql('DROP INDEX IDX_4C62E638C3C6F69F ON contact');
        $this->addSql('ALTER TABLE contact CHANGE car_id car_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A0EF1B80 FOREIGN KEY (car_id_id) REFERENCES cars (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638A0EF1B80 ON contact (car_id_id)');
        $this->addSql('ALTER TABLE photos CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE services CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonials CHANGE modified_at modified_at DATETIME DEFAULT NULL');
    }
}
