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

    /**
     * Prepares a statement for execution and returns a Statement object.
     */
    public function prepare($prepareString) : Statement
    {
        return new YamlDbStatement($prepareString, $this->yamlDb);
    }

    /**
     * Executes an SQL statement, returning a result set as a Statement object.
     */
    public function query() : Statement
    {
        $args = func_get_args();
        return new YamlDbStatement($args[0], $this->yamlDb);
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        return $input;
    }

    /**
     * Executes an SQL statement and return the number of affected rows.
     */
    public function exec($statement) : int
    {
        $doctrineStatement = $this->prepare($statement);
        $doctrineStatement->execute();

        return $doctrineStatement->rowCount();
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     */
    public function lastInsertId($name = null) : string
    {
        $lastInsertId = $this->yamlDb->lastInsertId();

        return $lastInsertId ? $lastInsertId->asString() : '';
    }

    /**
     * Initiates a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function beginTransaction() : bool
    {
        throw new LogicException('Transactions are not supported');
    }

    /**
     * Commits a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function commit() : bool
    {
        throw new LogicException('Transactions are not supported');
    }

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function rollBack() : bool
    {
        throw new LogicException('Transactions are not supported');
    }

    /**
     * Returns the error code associated with the last operation on the database handle.
     *
     * @return string|null The error code, or null if no operation has been run on the database handle.
     */
    public function errorCode() : ?string
    {
        return null;
    }

    /**
     * Returns extended error information associated with the last operation on the database handle.
     *
     * @return mixed[]
     */
    public function errorInfo() : array
    {
        return [];
    }
}
