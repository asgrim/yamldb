<?php

declare(strict_types=1);

namespace AsgrimUnitTest\YamlDb\Database;

use Asgrim\YamlDb\Database\FlysystemBackedYamlDb;
use Asgrim\YamlDb\YamlId;
use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use function chmod;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function mkdir;
use function rmdir;
use function sprintf;
use function sys_get_temp_dir;
use function touch;
use function unlink;

/** @covers \Asgrim\YamlDb\Database\FlysystemBackedYamlDb */
final class FlysystemBackedYamlDbTest extends TestCase
{
    /** @var string */
    private $dataPath;

    /** @var string */
    private $filename;

    /** @var FlysystemBackedYamlDb */
    private $yamlDb;

    /** @throws Exception */
    public function setUp() : void
    {
        parent::setUp();

        $this->dataPath = sys_get_temp_dir() . '/yaml-db-test' . Uuid::uuid4()->toString();
        mkdir($this->dataPath, 0777, true);
        $this->filename = $this->dataPath . '/database.yaml';

        $this->yamlDb = new FlysystemBackedYamlDb(new Filesystem(new Local($this->dataPath)));
    }

    public function tearDown() : void
    {
        parent::tearDown();

        if (file_exists($this->filename)) {
            unlink($this->filename);
        }

        if (! file_exists($this->dataPath)) {
            return;
        }

        rmdir($this->dataPath);
    }

    /** @throws Exception */
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

    public function testInsertThrowsExceptionWhenFlystemReturnsFalseFromFileLoad() : void
    {
        touch($this->filename);
        chmod($this->filename, 0000);

        $this->expectException(RuntimeException::class);
        $this->yamlDb->insert(['foo' => 'bar']);
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
