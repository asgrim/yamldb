<?php

declare(strict_types=1);

namespace Asgrim\YamlDb;

// @todo implement an interface
use Symfony\Component\Yaml\Yaml;

final class YamlDb
{
    /** @var string */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    // @todo maybe YamlDb\Storage\Persistence
    private function persist(array $dbContent): void
    {
        file_put_contents($this->filename, Yaml::dump($dbContent));
    }

    private function load(): array
    {
        if (!file_exists($this->filename)) {
            return [];
        }

        return Yaml::parseFile($this->filename);
    }

    public function insert(array $data): YamlId
    {
        $id = YamlId::new();

        $dbContent = $this->load();
        $dbContent[$id->asString()] = $data;

        $this->persist($dbContent);

        return $id;
    }

    public function findById(YamlId $id): array
    {
        $dbContent = $this->load();

        if (!array_key_exists($id->asString(), $dbContent)) {
            throw new \OutOfBoundsException('does not exist - ' . $id->asString());
        }

        return $dbContent[$id->asString()];
    }
}
