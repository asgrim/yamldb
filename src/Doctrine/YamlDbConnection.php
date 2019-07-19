<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Asgrim\YamlDb\YamlDb;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;
use LogicException;
use function func_get_args;

final class YamlDbConnection implements Connection
{
    /** @var YamlDb */
    private $yamlDb;

    public function __construct(YamlDb $yamlDb)
    {
        $this->yamlDb = $yamlDb;
    }

    public function prepare($prepareString) : Statement
    {
        return new YamlDbStatement($prepareString, $this->yamlDb);
    }

    public function query() : Statement
    {
        $args = func_get_args();

        return new YamlDbStatement($args[0], $this->yamlDb);
    }

    /**
     * @param mixed $input
     * @return mixed
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        return $input;
    }

    public function exec($statement) : int
    {
        $doctrineStatement = $this->prepare($statement);
        $doctrineStatement->execute();

        return $doctrineStatement->rowCount();
    }

    public function lastInsertId($name = null) : string
    {
        $lastInsertId = $this->yamlDb->lastInsertId();

        return $lastInsertId ? $lastInsertId->asString() : '';
    }

    public function beginTransaction() : bool
    {
        throw new LogicException('Transactions are not supported');
    }

    public function commit() : bool
    {
        throw new LogicException('Transactions are not supported');
    }

    public function rollBack() : bool
    {
        throw new LogicException('Transactions are not supported');
    }

    public function errorCode() : ?string
    {
        return null;
    }

    public function errorInfo() : array
    {
        return [];
    }
}
