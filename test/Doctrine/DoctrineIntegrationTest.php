<?php

declare(strict_types=1);

namespace AsgrimUnitTest\YamlDb\Doctrine;

use Asgrim\YamlDb\Doctrine\YamlDbDriver;
use Asgrim\YamlDb\Doctrine\YamlDbStatement;
use Asgrim\YamlDb\YamlDb;
use Asgrim\YamlDb\YamlId;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbConnection
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbDriver
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbPlatform
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbSchemaManager
 * @covers \Asgrim\YamlDb\Doctrine\YamlDbStatement
 */
final class DoctrineIntegrationTest extends TestCase
{
    /** @var YamlDb&MockObject */
    private $yamlDb;

    /** @var Connection */
    private $doctrine;

    /** @throws DBALException */
    public function setUp() : void
    {
        parent::setUp();

        $this->yamlDb = $this->createMock(YamlDb::class);

        $this->doctrine = DriverManager::getConnection(
            [
                'driverClass' => YamlDbDriver::class,
                YamlDb::class => $this->yamlDb,
            ],
            new Configuration()
        );
    }

    /**
     * @throws Exception
     */
    public function testInsertUsingDbalInsertMethod() : void
    {
        $this->yamlDb->expects(self::once())
            ->method('insert')
            ->with(['table' => 'test', 'row' => ['foo' => 'bar', 'bat' => 'baz']])
            ->willReturn(YamlId::new());

        self::assertSame(1, $this->doctrine->insert('test', ['foo' => 'bar', 'bat' => 'baz']));
    }

    /**
     * @throws DBALException
     * @throws Exception
     */
    public function testInsertUsingQueryWithSqlMethodAndNoParameters() : void
    {
        $this->yamlDb->expects(self::once())
            ->method('insert')
            ->with(['table' => 'testTable', 'row' => ['foo' => 'bar']])
            ->willReturn(YamlId::new());

        $statement = $this->doctrine->query('INSERT INTO testTable (foo) VALUES(\'bar\')');
        self::assertInstanceOf(YamlDbStatement::class, $statement);
        self::assertTrue($statement->execute());
    }
}
