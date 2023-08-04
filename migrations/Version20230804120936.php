<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804120936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE photo CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE service CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE testimonial ADD created_by_id INT DEFAULT NULL, CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E6BDCDF7B03A8386 ON testimonial (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE photo CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7B03A8386');
        $this->addSql('DROP INDEX IDX_E6BDCDF7B03A8386 ON testimonial');
        $this->addSql('ALTER TABLE testimonial DROP created_by_id, CHANGE modified_at modified_at DATETIME DEFAULT NULL');
    }
}
