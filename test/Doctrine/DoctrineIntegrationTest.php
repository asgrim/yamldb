<?php
declare(strict_types=1);

namespace AsgrimUnitTest\YamlDb\Doctrine;

use Asgrim\YamlDb\Doctrine\YamlDbDriver;
use Asgrim\YamlDb\YamlDb;
use Asgrim\YamlDb\YamlId;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbDriver
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbPlatform
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbSchemaManager
 */
final class DoctrineIntegrationTest extends TestCase
{
    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function test()
    {
        $yamlDb = $this->createMock(YamlDb::class);
        $yamlDb->expects(self::once())
            ->method('insert')
            ->with(['table' => 'test', 'row' => ['foo' => 'bar', 'bat' => 'baz']] )
            ->willReturn(YamlId::new());

        $config = new Configuration();
        $params = [
            'driverClass' => YamlDbDriver::class,
            YamlDb::class => $yamlDb,
        ];

        $connection = DriverManager::getConnection($params, $config);
        self::assertSame(1, $connection->insert('test', ['foo' => 'bar', 'bat' => 'baz']));
    }
}
