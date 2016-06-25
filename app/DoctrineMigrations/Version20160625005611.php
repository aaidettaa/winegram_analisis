<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160625005611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id VARCHAR(255) NOT NULL, originalText VARCHAR(100) NOT NULL, retweet_count VARCHAR(255) DEFAULT NULL, favorite_count VARCHAR(255) DEFAULT NULL, lang VARCHAR(255) DEFAULT NULL, user VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, englishText VARCHAR(255) DEFAULT NULL, publishDate VARCHAR(255) DEFAULT NULL, textSentiment VARCHAR(255) DEFAULT NULL, textTwittSentiment VARCHAR(255) DEFAULT NULL, wine_id VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, idRedis VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id VARCHAR(255) NOT NULL, text VARCHAR(100) NOT NULL, comment_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tone (id VARCHAR(255) NOT NULL, score NUMERIC(7, 6) NOT NULL, tone_id VARCHAR(255) NOT NULL, tone_name VARCHAR(100) NOT NULL, tone_categorie_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toneCategorie (id VARCHAR(255) NOT NULL, category_id VARCHAR(255) NOT NULL, category_name VARCHAR(255) NOT NULL, comment_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE tone');
        $this->addSql('DROP TABLE toneCategorie');
    }
}
