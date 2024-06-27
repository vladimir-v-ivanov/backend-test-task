<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626111633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('products');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('name', Types::STRING)->setLength(255);
        $table->addColumn('price', Types::INTEGER);
        $table->setPrimaryKey(['id']);

        $table = $schema->createTable('discount_coupons');
        $table->addColumn('code', Types::STRING);
        $table->addColumn('discount', Types::INTEGER);
        $table->setPrimaryKey(['code']);

        $table = $schema->createTable('tax_countries');
        $table->addColumn('country_code', Types::STRING)->setLength(2)->setFixed(true);
        $table->addColumn('tax_value', Types::INTEGER);
        $table->setPrimaryKey(['country_code']);

        $table = $schema->createTable('orders');
        $table->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $table->addColumn('product_id', Types::INTEGER);
        $table->addColumn('discount_coupon', Types::STRING);
        $table->addColumn('tax_number', Types::STRING);
        $table->addColumn('status', Types::STRING);
    }

    public function down(Schema $schema): void
    {
        $this->backupTable($schema, 'products');
        $this->backupTable($schema, 'discount_coupons');
        $this->backupTable($schema, 'tax_countries');
        $this->backupTable($schema, 'orders');
    }

    /**
     * @throws SchemaException
     */
    private function backupTable(Schema $schema, string $tableName): void
    {
        $suffix = 1;

        while (true) {
            $backupTableName = "{$tableName}_backup$suffix";

            try {
                $schema->getTable($backupTableName);
            } catch (SchemaException) {
                $schema->renameTable($tableName, $backupTableName);

                break;
            }

            $suffix++;
        }
    }
}
