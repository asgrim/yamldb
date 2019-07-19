<?php
declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Asgrim\YamlDb\YamlDb;
use Asgrim\YamlDb\YamlId;
use Assert\Assert;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use PDO;
use Traversable;

final class YamlDbStatement implements IteratorAggregate, Statement
{
    private const SUPPORTED_INSERT_FORMAT = "/INSERT INTO ([a-zA-Z0-9_-]+) \(((?:[a-zA-Z0-9_-]+[, ]*)+)\) VALUES\s?\(((?:[a-zA-Z0-9_\'\?-]+[, ]*)+)\)/";

    /** var string */
    private $statement;

    /** @var YamlDb */
    private $yamlDb;

    /** @var int */
    private $affectedRows = 0;

    public function __construct(string $statement, YamlDb $yamlDb)
    {
        $this->statement = $statement;
        $this->yamlDb = $yamlDb;
    }

    /**
     * @param array<string|int, mixed> $params
     */
    private function replaceParamsInStatement(string $statement, array $params = []): string
    {
        if (strpos($statement, '?') === false) {
            return $statement;
        }

        $statement = preg_replace('/(\?)/', reset($params), $statement, 1);
        Assert::that($statement)->string('Failed to preg_replace a parameter out');
        array_shift($params);

        return $this->replaceParamsInStatement($statement, $params);
    }

    private function unquoteIdentifier(string $value): string
    {
        return trim($value, "` \t\n\r\0\x0B");
    }

    private function unquoteValue(string $value): string
    {
        return trim($value,"\"' \t\n\r\0\x0B");
    }

    /**
     * @param array<string|int, mixed> $params
     */
    private function deconstructAndExecute(string $statement, array $params = []) : YamlId
    {
        $statement = $this->replaceParamsInStatement($statement, $params);

        if ((stripos($statement, 'INSERT') === 0) && preg_match(self::SUPPORTED_INSERT_FORMAT, $statement, $matches) === 1) {
            $tableName = $matches[1];
            $columns = array_map([$this, 'unquoteIdentifier'], explode(',', $matches[2]));
            $values = array_map([$this, 'unquoteValue'], explode(',', $matches[3]));

            $colsWithValues = array_combine($columns, $values);

            return $this->yamlDb->insert(['table' => $tableName, 'row' => $colsWithValues]);
        }

        throw new \LogicException('YamlDb does not support the query: ' . $statement);
    }

    /**
     * Closes the cursor, enabling the statement to be executed again.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function closeCursor()
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the number of columns in the result set
     *
     * @return int The number of columns in the result set represented
     *                 by the PDOStatement object. If there is no result set,
     *                 this method should return 0.
     */
    public function columnCount()
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Sets the fetch mode to use while iterating this statement.
     *
     * @param int $fetchMode The fetch mode must be one of the {@link \Doctrine\DBAL\FetchMode} constants.
     * @param mixed $arg2
     * @param mixed $arg3
     *
     * @return bool
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        return true;
    }

    /**
     * Returns the next row of a result set.
     *
     * @param int|null $fetchMode Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     * @param int $cursorOrientation For a ResultStatement object representing a scrollable cursor,
     *                                    this value determines which row will be returned to the caller.
     *                                    This value must be one of the \PDO::FETCH_ORI_* constants,
     *                                    defaulting to \PDO::FETCH_ORI_NEXT. To request a scrollable
     *                                    cursor for your ResultStatement object, you must set the \PDO::ATTR_CURSOR
     *                                    attribute to \PDO::CURSOR_SCROLL when you prepare the SQL statement with
     *                                    \PDO::prepare().
     * @param int $cursorOffset For a ResultStatement object representing a scrollable cursor for which the
     *                                    cursorOrientation parameter is set to \PDO::FETCH_ORI_ABS, this value
     *                                    specifies the absolute number of the row in the result set that shall be
     *                                    fetched.
     *                                    For a ResultStatement object representing a scrollable cursor for which the
     *                                    cursorOrientation parameter is set to \PDO::FETCH_ORI_REL, this value
     *                                    specifies the row to fetch relative to the cursor position before
     *                                    ResultStatement::fetch() was called.
     *
     * @return mixed The return value of this method on success depends on the fetch mode. In all cases, FALSE is
     *               returned on failure.
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns an array containing all of the result set rows.
     *
     * @param int|null $fetchMode Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     * @param int|null $fetchArgument This argument has a different meaning depending on the value of the $fetchMode parameter:
     *                                    * {@link \Doctrine\DBAL\FetchMode::COLUMN}:
     *                                      Returns the indicated 0-indexed column.
     *                                    * {@link \Doctrine\DBAL\FetchMode::CUSTOM_OBJECT}:
     *                                      Returns instances of the specified class, mapping the columns of each row
     *                                      to named properties in the class.
     *                                    * \PDO::FETCH_FUNC: Returns the results of calling the specified function, using each row's
     *                                      columns as parameters in the call.
     * @param mixed[]|null $ctorArgs Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     *
     * @return mixed[]
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns a single column from the next row of a result set or FALSE if there are no more rows.
     *
     * @param int $columnIndex 0-indexed number of the column you wish to retrieve from the row.
     *                         If no value is supplied, fetches the first column.
     *
     * @return mixed|false A single column in the next row of a result set, or FALSE if there are no more rows.
     */
    public function fetchColumn($columnIndex = 0)
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional
     * placeholder in the SQL statement that was used to prepare the statement.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * @param mixed $param Parameter identifier. For a prepared statement using named placeholders,
     *                     this will be a parameter name of the form :name. For a prepared statement
     *                     using question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed $value The value to bind to the parameter.
     * @param int $type Explicit data type for the parameter using the {@link \Doctrine\DBAL\ParameterType}
     *                     constants.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function bindValue($param, $value, $type = ParameterType::STRING)
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Binds a PHP variable to a corresponding named (not supported by mysqli driver, see comment below) or question
     * mark placeholder in the SQL statement that was use to prepare the statement. Unlike PDOStatement->bindValue(),
     * the variable is bound as a reference and will only be evaluated at the time
     * that PDOStatement->execute() is called.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * Most parameters are input parameters, that is, parameters that are
     * used in a read-only fashion to build up the query. Some drivers support the invocation
     * of stored procedures that return data as output parameters, and some also as input/output
     * parameters that both send in data and are updated to receive it.
     *
     * @param mixed $column Parameter identifier. For a prepared statement using named placeholders,
     *                           this will be a parameter name of the form :name. For a prepared statement using
     *                           question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed $variable Name of the PHP variable to bind to the SQL statement parameter.
     * @param int|null $type Explicit data type for the parameter using the {@link \Doctrine\DBAL\ParameterType}
     *                           constants. To return an INOUT parameter from a stored procedure, use the bitwise
     *                           OR operator to set the PDO::PARAM_INPUT_OUTPUT bits for the data_type parameter.
     * @param int|null $length You must specify maxlength when using an OUT bind
     *                           so that PHP allocates enough memory to hold the returned value.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null)
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Fetches the SQLSTATE associated with the last operation on the statement handle.
     *
     * @return string|int|bool The error code string.
     * @see Doctrine_Adapter_Interface::errorCode()
     *
     */
    public function errorCode()
    {
        return false;
    }

    /**
     * Fetches extended error information associated with the last operation on the statement handle.
     *
     * @return mixed[] The error info array.
     */
    public function errorInfo()
    {
        return [];
    }

    /**
     * Executes a prepared statement
     *
     * If the prepared statement included parameter markers, you must either:
     * call PDOStatement->bindParam() to bind PHP variables to the parameter markers:
     * bound variables pass their value as input and receive the output value,
     * if any, of their associated parameter markers or pass an array of input-only
     * parameter values.
     *
     * @param mixed[]|null $params An array of values with as many elements as there are
     *                             bound parameters in the SQL statement being executed.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function execute($params = null)
    {
        if ($params === null) {
            $params = [];
        }
        $this->deconstructAndExecute($this->statement, $params);
        $this->affectedRows++;
        return true;
    }

    /**
     * Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement
     * executed by the corresponding object.
     *
     * If the last SQL statement executed by the associated Statement object was a SELECT statement,
     * some databases may return the number of rows returned by that statement. However,
     * this behaviour is not guaranteed for all databases and should not be
     * relied on for portable applications.
     *
     * @return int The number of rows.
     */
    public function rowCount()
    {
        return $this->affectedRows;
    }

    /**
     * Retrieve an external iterator
     *
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        throw new \LogicException('Not implemented yet: ' . __METHOD__);
    }
}
