<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Database;

use Asgrim\YamlDb\YamlDb;
use Asgrim\YamlDb\YamlId;
use Exception;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use OutOfBoundsException;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;
use function array_key_exists;
use function is_string;

final class FlysystemBackedYamlDb implements YamlDb
{
    private const FIXED_YAML_DB_FILE = 'database.yaml';

    /** @var FilesystemInterface */
    private $dataPath;

    /** @var YamlId|null */
    private $lastInsertId;

    public function __construct(FilesystemInterface $dataPath)
    {
        $this->dataPath = $dataPath;
    }

    /**
     * @param mixed[] $dbContent
     *
     * @throws FileExistsException
     */
    private function persist(array $dbContent) : void
    {
        $this->dataPath->write(self::FIXED_YAML_DB_FILE, Yaml::dump($dbContent));
    }

    /**
     * @return mixed[]
     *
     * @throws FileNotFoundException
     */
    private function load() : array
    {
        if (! $this->dataPath->has(self::FIXED_YAML_DB_FILE)) {
            return [];
        }

        $fileContent = $this->dataPath->read(self::FIXED_YAML_DB_FILE);

        if (! is_string($fileContent)) {
            throw new RuntimeException('Failed to load file');
        }

        return Yaml::parse($fileContent);
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

        $this->lastInsertId = $id;

        return $id;
    }

    /**
     * @return mixed[]
     *
     * @throws FileNotFoundException
     */
    public function findById(YamlId $id) : array
    {
        $dbContent = $this->load();

        if (! array_key_exists($id->asString(), $dbContent)) {
            throw new OutOfBoundsException('does not exist - ' . $id->asString());
        }

        return $dbContent[$id->asString()];
    }

    public function lastInsertId() : ?YamlId
    {
        return $this->lastInsertId;
    }
}
