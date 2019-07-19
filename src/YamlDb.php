<?php

declare(strict_types=1);

namespace Asgrim\YamlDb;

interface YamlDb
{
    public function insert(array $data) : YamlId;

    public function findById(YamlId $id) : array;

    public function lastInsertId() : ?YamlId;
}
