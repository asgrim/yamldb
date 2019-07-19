<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Asgrim\YamlDb\YamlDb;
use Asgrim\YamlDb\YamlId;
use Assert\Assert;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use LogicException;
use PDO;
use Traversable;
use function array_combine;
use function array_map;
use function array_shift;
use function explode;
use function preg_match;
use function preg_replace;
use function reset;
use function stripos;
use function strpos;
use function trim;

final class YamlDbStatement implements IteratorAggregate, Statement
{
    private const SUPPORTED_INSERT_FORMAT = "/INSERT INTO ([a-zA-Z0-9_-]+) \(((?:[a-zA-Z0-9_-]+[, ]*)+)\) VALUES\s?\(((?:[a-zA-Z0-9_\'\?-]+[, ]*)+)\)/";

    /** @var string */
    private $statement;

    /** @var YamlDb */
    private $yamlDb;

    /** @var int */
    private $affectedRows = 0;

    public function __construct(string $statement, YamlDb $yamlDb)
    {
        $this->statement = $statement;
        $this->yamlDb    = $yamlDb;
    }

    /**
     * @param array<string|int, mixed> $params
     */
    private function replaceParamsInStatement(string $statement, array $params = []) : string
    {
        if (strpos($statement, '?') === false) {
            return $statement;
        }

        $statement = preg_replace('/(\?)/', reset($params), $statement, 1);
        Assert::that($statement)->string('Failed to preg_replace a parameter out');
        array_shift($params);

        return $this->replaceParamsInStatement($statement, $params);
    }

    // phpcs:ignore SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedMethod
    private function unquoteIdentifier(string $value) : string
    {
        return trim($value, "` \t\n\r\0\x0B");
    }

    // phpcs:ignore SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedMethod
    private function unquoteValue(string $value) : string
    {
        return trim($value, "\"' \t\n\r\0\x0B");
    }

    /**
     * @param array<string|int, mixed> $params
     */
    private function deconstructAndExecute(string $statement, array $params = []) : YamlId
    {
        $statement = $this->replaceParamsInStatement($statement, $params);

        if ((stripos($statement, 'INSERT') === 0) && preg_match(self::SUPPORTED_INSERT_FORMAT, $statement, $matches) === 1) {
            $tableName = $matches[1];
            $columns   = array_map([$this, 'unquoteIdentifier'], explode(',', $matches[2]));
            $values    = array_map([$this, 'unquoteValue'], explode(',', $matches[3]));

            $colsWithValues = array_combine($columns, $values);

            return $this->yamlDb->insert(['table' => $tableName, 'row' => $colsWithValues]);
        }

        throw new LogicException('YamlDb does not support the query: ' . $statement);
    }

    public function closeCursor() : bool
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    public function columnCount() : int
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * @param int   $fetchMode
     * @param mixed $arg2
     * @param mixed $arg3
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null) : bool // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        return true;
    }

    /**
     * @param int|null $fetchMode
     * @param int      $cursorOrientation
     * @param int      $cursorOffset
     *
     * @return mixed|false
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0) // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * @param int|null     $fetchMode
     * @param int|null     $fetchArgument
     * @param mixed[]|null $ctorArgs
     *
     * @return mixed[]
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null) : array // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * @param int $columnIndex
     *
     * @return mixed|false
     */
    public function fetchColumn($columnIndex = 0) // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * @param mixed    $param
     * @param mixed    $value
     * @param int|null $type
     */
    public function bindValue($param, $value, $type = ParameterType::STRING) : bool // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * @param mixed    $column
     * @param mixed    $variable
     * @param int|null $type
     * @param int|null $length
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null) : bool // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    public function errorCode() : bool
    {
        return false;
    }

    /** @return mixed[] */
    public function errorInfo() : array
    {
        return [];
    }

    /** @param mixed[]|null $params */
    public function execute($params = null) : bool // phpcs:ignore SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
    {
        if ($params === null) {
            $params = [];
        }
        $this->deconstructAndExecute($this->statement, $params);
        $this->affectedRows++;

        return true;
    }

    public function rowCount() : int
    {
        return $this->affectedRows;
    }

    public function getIterator() : Traversable
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }
}
