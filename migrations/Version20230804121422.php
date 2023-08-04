<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804121422 extends AbstractMigration
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
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7A76ED395');
        $this->addSql('DROP INDEX IDX_E6BDCDF7A76ED395 ON testimonial');
        $this->addSql('ALTER TABLE testimonial CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP, CHANGE user_id approved_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF72D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E6BDCDF72D234F6A ON testimonial (approved_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE photo CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF72D234F6A');
        $this->addSql('DROP INDEX IDX_E6BDCDF72D234F6A ON testimonial');
        $this->addSql('ALTER TABLE testimonial CHANGE modified_at modified_at DATETIME DEFAULT NULL, CHANGE approved_by_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E6BDCDF7A76ED395 ON testimonial (user_id)');
    }
}
