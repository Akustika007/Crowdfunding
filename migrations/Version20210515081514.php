<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515081514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE crowdfunding_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crowdfunding_user (crowdfunding_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_77FB75C9A76ED395 (user_id), INDEX IDX_77FB75C9FC90B5CB (crowdfunding_id), PRIMARY KEY(crowdfunding_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE crowdfunding_user ADD CONSTRAINT FK_77FB75C9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE crowdfunding_user ADD CONSTRAINT FK_77FB75C9FC90B5CB FOREIGN KEY (crowdfunding_id) REFERENCES crowdfunding (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
