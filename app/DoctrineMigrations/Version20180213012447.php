<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180213012447 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE votes (id SERIAL NOT NULL, user_id INT NOT NULL, instrument_id INT NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_518B7ACFA76ED395 ON votes (user_id)');
        $this->addSql('CREATE INDEX IDX_518B7ACFCF11D9C ON votes (instrument_id)');
        $this->addSql('CREATE TABLE instruments (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vote_stats (id SERIAL NOT NULL, instrument_id INT NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, votes INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62E0561CF11D9C ON vote_stats (instrument_id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFCF11D9C FOREIGN KEY (instrument_id) REFERENCES instruments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vote_stats ADD CONSTRAINT FK_62E0561CF11D9C FOREIGN KEY (instrument_id) REFERENCES instruments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE votes DROP CONSTRAINT FK_518B7ACFCF11D9C');
        $this->addSql('ALTER TABLE vote_stats DROP CONSTRAINT FK_62E0561CF11D9C');
        $this->addSql('DROP TABLE votes');
        $this->addSql('DROP TABLE instruments');
        $this->addSql('DROP TABLE vote_stats');
    }
}
