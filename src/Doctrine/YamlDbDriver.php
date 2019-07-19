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

    public function getDatabasePlatform() : AbstractPlatform
    {
        return new YamlDbPlatform();
    }

    public function getSchemaManager(Connection $conn) : AbstractSchemaManager
    {
        return new YamlDbSchemaManager($conn);
    }

    public function getName() : string
    {
        return 'yamldb';
    }

    public function getDatabase(Connection $conn) : string
    {
        return 'yamldb';
    }
}
