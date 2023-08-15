<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230815194903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `schedule` VALUES (1,'{\"1\": \"Lun : 08h00 - 12h00, 13h00 - 17h00\", \"2\": \"Mar : 08h00 - 12h00, 13h00 - 17h00\", \"3\": \"Mer : 10h00 - 13h00, 14h00 - 18h00\", \"4\": \"Jeu : 08h00 - 12h00, 13h00 - 17h00\", \"5\": \"Ven : 08h00 - 12h00, 13h00 - 17h00\", \"6\": \"Sam : 10h00 - 12h00, 13h00 - 16h00\", \"7\": \"Dim : fermé\"}');");
        $this->addSql("INSERT INTO `garage` VALUES (1,1,'Siege Social','vincentParrot@VP.com','0123456789','7 avenue du vase de Soissons, 31000 Toulouse'),(11,NULL,'Marseille','gvp@vp.com','0123456789','blablabla');");
        $this->addSql("INSERT INTO `user` VALUES (1,1,'vincentParrot@VP.com','$2y$13\$vTUgEfGhWNnwfSbpGLks1u95lSRJR3SI9xLwP0sAbjVoKezcc7fUm','Vincent','Parrot','[\"ROLE_SUPER_ADMIN\"]');");
    }

}
