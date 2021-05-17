<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517142312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bonus (id INT AUTO_INCREMENT NOT NULL, crowdfunding_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, price INT NOT NULL, INDEX IDX_9F987F7AFC90B5CB (crowdfunding_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, crowdfunding_id INT NOT NULL, text VARCHAR(800) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526CFC90B5CB (crowdfunding_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crowdfunding (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, status INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, description_long LONGTEXT DEFAULT NULL, country VARCHAR(128) DEFAULT NULL, finished_at DATETIME NOT NULL, money_purpose INT NOT NULL, money_collected INT DEFAULT NULL, INDEX IDX_2CB9C2ADA76ED395 (user_id), INDEX IDX_2CB9C2AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, crowdfunding_id INT NOT NULL, bonus_id INT DEFAULT NULL, amount INT NOT NULL, sent_at DATETIME NOT NULL, INDEX IDX_6D28840DA76ED395 (user_id), INDEX IDX_6D28840DFC90B5CB (crowdfunding_id), INDEX IDX_6D28840D69545666 (bonus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (crowdfunding_id INT NOT NULL, user_id INT NOT NULL, rating INT NOT NULL, INDEX IDX_D8892622FC90B5CB (crowdfunding_id), INDEX IDX_D8892622A76ED395 (user_id), PRIMARY KEY(crowdfunding_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, status INT NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bonus ADD CONSTRAINT FK_9F987F7AFC90B5CB FOREIGN KEY (crowdfunding_id) REFERENCES crowdfunding (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFC90B5CB FOREIGN KEY (crowdfunding_id) REFERENCES crowdfunding (id)');
        $this->addSql('ALTER TABLE crowdfunding ADD CONSTRAINT FK_2CB9C2ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE crowdfunding ADD CONSTRAINT FK_2CB9C2AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DFC90B5CB FOREIGN KEY (crowdfunding_id) REFERENCES crowdfunding (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D69545666 FOREIGN KEY (bonus_id) REFERENCES bonus (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622FC90B5CB FOREIGN KEY (crowdfunding_id) REFERENCES crowdfunding (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D69545666');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE crowdfunding DROP FOREIGN KEY FK_2CB9C2AD12469DE2');
        $this->addSql('ALTER TABLE bonus DROP FOREIGN KEY FK_9F987F7AFC90B5CB');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CFC90B5CB');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DFC90B5CB');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622FC90B5CB');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE crowdfunding DROP FOREIGN KEY FK_2CB9C2ADA76ED395');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A76ED395');
        $this->addSql('DROP TABLE bonus');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE crowdfunding');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE user');
    }
}
