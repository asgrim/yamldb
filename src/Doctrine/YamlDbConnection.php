<?php

namespace Asgrim\YamlDb\Doctrine;

use Asgrim\YamlDb\YamlDb;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;

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
     *
     * @param string $prepareString
     *
     * @return Statement
     */
    public function prepare($prepareString)
    {
        return new YamlDbStatement($prepareString, $this->yamlDb);
    }

    /**
     * Executes an SQL statement, returning a result set as a Statement object.
     *
     * @return Statement
     */
    public function query()
    {
        return new YamlDbStatement(func_get_args()[0], $this->yamlDb);
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param mixed $input
     * @param int $type
     *
     * @return mixed
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        // TODO: Implement quote() method.
    }

    /**
     * Executes an SQL statement and return the number of affected rows.
     *
     * @param string $statement
     *
     * @return int
     */
    public function exec($statement)
    {
        // TODO: Implement exec() method.
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @param string|null $name
     *
     * @return string
     */
    public function lastInsertId($name = null)
    {
        // TODO: Implement lastInsertId() method.
    }

    /**
     * Initiates a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    /**
     * Commits a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function commit()
    {
        // TODO: Implement commit() method.
    }

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function rollBack()
    {
        // TODO: Implement rollBack() method.
    }

    /**
     * Returns the error code associated with the last operation on the database handle.
     *
     * @return string|null The error code, or null if no operation has been run on the database handle.
     */
    public function errorCode()
    {
        // TODO: Implement errorCode() method.
    }

    /**
     * Returns extended error information associated with the last operation on the database handle.
     *
     * @return mixed[]
     */
    public function errorInfo()
    {
        // TODO: Implement errorInfo() method.
    }
}
