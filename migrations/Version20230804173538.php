<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804173538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D8565851');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('ALTER TABLE car CHANGE user_id user_id INT DEFAULT NULL, CHANGE establishment_id establishment_id INT DEFAULT NULL, CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FEC3C6F69F');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FEC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE establishment DROP FOREIGN KEY FK_DBEFB1EEA76ED395');
        $this->addSql('ALTER TABLE establishment ADD CONSTRAINT FK_DBEFB1EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE photo CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('ALTER TABLE service CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF72D234F6A');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7B03A8386');
        $this->addSql('ALTER TABLE testimonial CHANGE modified_at modified_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF72D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D8565851');
        $this->addSql('ALTER TABLE car CHANGE user_id user_id INT NOT NULL, CHANGE establishment_id establishment_id INT NOT NULL, CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id)');
        $this->addSql('ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FEC3C6F69F');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FEC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE establishment DROP FOREIGN KEY FK_DBEFB1EEA76ED395');
        $this->addSql('ALTER TABLE establishment ADD CONSTRAINT FK_DBEFB1EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('ALTER TABLE service CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7B03A8386');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF72D234F6A');
        $this->addSql('ALTER TABLE testimonial CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF72D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id)');
    }
}
