<?php
declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Asgrim\YamlDb\YamlDb;
use Assert\Assert;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

final class YamlDbDriver implements Driver
{
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        Assert::that($params)->keyExists(YamlDb::class);
        Assert::that($params[YamlDb::class])->isInstanceOf(YamlDb::class);
        return new YamlDbConnection($params[YamlDb::class]);
    }

    /**
     * Gets the DatabasePlatform instance that provides all the metadata about
     * the platform this driver connects to.
     *
     * @return AbstractPlatform The database platform.
     */
    public function getDatabasePlatform()
    {
        return new YamlDbPlatform();
    }

    /**
     * Gets the SchemaManager that can be used to inspect and change the underlying
     * database schema of the platform this driver connects to.
     *
     * @return AbstractSchemaManager
     */
    public function getSchemaManager(Connection $conn)
    {
        return new YamlDbSchemaManager($conn);
    }

    /**
     * Gets the name of the driver.
     *
     * @return string The name of the driver.
     */
    public function getName()
    {
        return 'yamldb';
    }

    /**
     * Gets the name of the database connected to for this driver.
     *
     * @return string The name of the database.
     */
    public function getDatabase(Connection $conn)
    {
        return 'yaml';
    }
}
