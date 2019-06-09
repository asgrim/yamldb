<?php

declare(strict_types=1);

namespace Asgrim\YamlDb;

use Assert\Assert;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class YamlId
{
    /** @var UuidInterface */
    private $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /** @throws Exception */
    public static function new() : self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $id) : self
    {
        Assert::that($id)->uuid();

        return new self(Uuid::fromString($id));
    }

    public function asString() : string
    {
        return $this->id->toString();
    }
}
