<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Database;

use Asgrim\YamlDb\YamlDb;
use Asgrim\YamlDb\YamlId;
use Exception;
use OutOfBoundsException;
use Symfony\Component\Yaml\Yaml;
use function array_key_exists;
use function file_exists;
use function file_put_contents;

final class FlysystemBackedYamlDb implements YamlDb
{
    /** @var string */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /** @param mixed[] $dbContent */
    private function persist(array $dbContent) : void
    {
        file_put_contents($this->filename, Yaml::dump($dbContent));
    }

    /** @return mixed[] */
    private function load() : array
    {
        if (! file_exists($this->filename)) {
            return [];
        }

        return Yaml::parseFile($this->filename);
    }

    /**
     * @param mixed[] $data
     *
     * @throws Exception
     */
    public function insert(array $data) : YamlId
    {
        $id = YamlId::new();

        $dbContent                  = $this->load();
        $dbContent[$id->asString()] = $data;

        $this->persist($dbContent);

        return $id;
    }

    /** @return mixed[] */
    public function findById(YamlId $id) : array
    {
        $dbContent = $this->load();

        if (! array_key_exists($id->asString(), $dbContent)) {
            throw new OutOfBoundsException('does not exist - ' . $id->asString());
        }

        return $dbContent[$id->asString()];
    }
}
