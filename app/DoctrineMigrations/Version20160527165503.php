<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class Version20160527165503
 * Migration: added stock and price columns into tblProductData (ref Jira SELF-3099)
 *
 * @package Application\Migrations
 */
class Version20160527165503 extends AbstractMigration
{
    /**
     * Before up
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function preUp(Schema $schema)
    {
        // platform checking
        if ($this->connection->getDatabasePlatform()->getName() != 'mysql') {
            $this->abortIf(true, "Migration can only be executed safely on 'mysql'.");
        }
    }

    /**
     * Migration up
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
          ALTER TABLE tblProductData
            ADD intStock INT NOT NULL,
            ADD floatCostInGBP NUMERIC(15, 2) NOT NULL
        ");

    }

    /**
     * Before down
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function preDown(Schema $schema)
    {
        // platform checking
        if ($this->connection->getDatabasePlatform()->getName() != 'mysql') {
            $this->abortIf(true, "Migration can only be executed safely on 'mysql'.");
        }
    }

    /**
     * Migration down
     *
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE tblProductData
              DROP intStock,
              DROP floatCostInGBP
        ");
    }
}
