<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180212203617 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE user_role (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, status_id INT NOT NULL, role_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_active BOOLEAN DEFAULT NULL, is_blocked BOOLEAN DEFAULT \'false\' NOT NULL, is_deleted BOOLEAN DEFAULT \'false\' NOT NULL, is_superuser BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX role_id__idx ON users (role_id)');
        $this->addSql('CREATE INDEX status_id__idx ON users (status_id)');
        $this->addSql('CREATE INDEX login_credenitials__idx ON users (login, password)');
        $this->addSql('CREATE INDEX user_name__idx ON users (lastname, firstname)');
        $this->addSql('CREATE UNIQUE INDEX email__idx ON users (email)');
        $this->addSql('CREATE TABLE user_status (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_statuses_code__idx ON user_status (code)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E96BF700BD FOREIGN KEY (status_id) REFERENCES user_status (id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES user_role (id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9D60322AC');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E96BF700BD');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_status');
    }
}
