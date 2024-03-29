<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820135129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, garage_id INT DEFAULT NULL, constructor VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, engine VARCHAR(50) NOT NULL, license_plate VARCHAR(9) NOT NULL, registration_year INT NOT NULL, mileage INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME on update CURRENT_TIMESTAMP, published TINYINT(1) NOT NULL, INDEX IDX_773DE69DB03A8386 (created_by_id), INDEX IDX_773DE69DC4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, subject VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, terms_accepted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2C9211FEC3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage (id INT AUTO_INCREMENT NOT NULL, schedule_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(150) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_9F26610BA40BC2D5 (schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, filename VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, image_size INT NOT NULL, mime_type VARCHAR(50) NOT NULL, modified_at DATETIME on update CURRENT_TIMESTAMP, INDEX IDX_14B78418C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT NOT NULL, opened_days JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, image_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME on update CURRENT_TIMESTAMP, published TINYINT(1) NOT NULL, INDEX IDX_E19D9AD2B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_garage (service_id INT NOT NULL, garage_id INT NOT NULL, INDEX IDX_A1E1643DED5CA9E6 (service_id), INDEX IDX_A1E1643DC4FFF555 (garage_id), PRIMARY KEY(service_id, garage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimonial (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, approved_by_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, note SMALLINT NOT NULL, is_approved TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME on update CURRENT_TIMESTAMP, INDEX IDX_E6BDCDF7B03A8386 (created_by_id), INDEX IDX_E6BDCDF72D234F6A (approved_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(60) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649C4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FEC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE garage ADD CONSTRAINT FK_9F26610BA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE service_garage ADD CONSTRAINT FK_A1E1643DED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_garage ADD CONSTRAINT FK_A1E1643DC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF72D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB03A8386');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DC4FFF555');
        $this->addSql('ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FEC3C6F69F');
        $this->addSql('ALTER TABLE garage DROP FOREIGN KEY FK_9F26610BA40BC2D5');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418C3C6F69F');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2B03A8386');
        $this->addSql('ALTER TABLE service_garage DROP FOREIGN KEY FK_A1E1643DED5CA9E6');
        $this->addSql('ALTER TABLE service_garage DROP FOREIGN KEY FK_A1E1643DC4FFF555');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7B03A8386');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF72D234F6A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C4FFF555');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE garage');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_garage');
        $this->addSql('DROP TABLE testimonial');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
