<?php

declare(strict_types=1);

namespace AsgrimUnitTest\YamlDb\Database;

use Asgrim\YamlDb\Database\FlysystemBackedYamlDb;
use Asgrim\YamlDb\YamlId;
use Exception;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function sprintf;
use function unlink;

/** @covers \Asgrim\YamlDb\Database\FlysystemBackedYamlDb */
final class FlysystemBackedYamlDbTest extends TestCase
{
    /** @var string */
    private $filename;

    /** @var FlysystemBackedYamlDb */
    private $yamlDb;

    public function setUp() : void
    {
        parent::setUp();

        $this->filename = 'test.yaml';
        $this->yamlDb   = new FlysystemBackedYamlDb($this->filename);
    }

    public function tearDown() : void
    {
        parent::tearDown();

        if (! file_exists($this->filename)) {
            return;
        }

        unlink($this->filename);
    }

    public function testInsert() : void
    {
        $id = $this->yamlDb->insert(['foo' => 'bar']);

        self::assertSame(
            <<<DOC
{$id->asString()}:
    foo: bar

DOC,
            file_get_contents($this->filename)
        );
    }

    /** @throws Exception */
    public function testFindById() : void
    {
        $id = YamlId::new();

        file_put_contents($this->filename, sprintf("%s:\n    foo: bar\n", $id->asString()));

        self::assertEquals(
            ['foo' => 'bar'],
            $this->yamlDb->findById($id)
        );
    }

    /** @throws Exception */
    public function testFindByIdThrowsExceptionWhenNotFound() : void
    {
        $id = YamlId::new();

        $this->expectException(OutOfBoundsException::class);
        /** @noinspection UnusedFunctionResultInspection */
        $this->yamlDb->findById($id);
    }
}
