<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160625141230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag (id VARCHAR(255) NOT NULL, text VARCHAR(100) NOT NULL, comment_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD likes_count VARCHAR(255) DEFAULT NULL, ADD username VARCHAR(255) DEFAULT NULL, ADD media VARCHAR(255) DEFAULT NULL, ADD search_id VARCHAR(255) DEFAULT NULL, ADD search_content VARCHAR(255) DEFAULT NULL, ADD query VARCHAR(255) DEFAULT NULL, DROP retweet_count, DROP favorite_count, DROP user, DROP location, DROP publishDate, DROP wine_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tag');
        $this->addSql('ALTER TABLE comment ADD retweet_count VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD favorite_count VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD user VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD location VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD publishDate VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD wine_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP likes_count, DROP username, DROP media, DROP search_id, DROP search_content, DROP query');
    }
}
