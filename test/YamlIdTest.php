<?php

declare(strict_types=1);

namespace AsgrimUnitTest\YamlDb;

use Asgrim\YamlDb\YamlId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/** @covers \Asgrim\YamlDb\YamlId */
final class YamlIdTest extends TestCase
{
    public function testNonUuidStringIsRejected() : void
    {
        $this->expectException(InvalidArgumentException::class);
        YamlId::fromString('not a uuid');
    }

    public function testValidYamlIdCanBeCreatedAndStringified() : void
    {
        $uuid = Uuid::uuid4();
        $id   = YamlId::fromString($uuid->toString());
        self::assertSame($uuid->toString(), $id->asString());
    }

    public function testNewYamlIdCanBeGenerated() : void
    {
        $id = YamlId::new();
        self::assertTrue(Uuid::isValid($id->asString()));
    }
}
