<?php

declare(strict_types=1);

namespace Asgrim\YamlDb;

interface YamlDb
{
    /** @param array<mixed, mixed> $data */
    public function insert(array $data) : YamlId;

    /** @return array<mixed, mixed> */
    public function findById(YamlId $id) : array;

    public function lastInsertId() : ?YamlId;
}
