<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Types\Type;

final class YamlDbSchemaManager extends AbstractSchemaManager
{
    /**
     * @param mixed[] $tableColumn
     */
    protected function _getPortableTableColumnDefinition($tableColumn) : Column // phpcs:ignore
    {
        return new Column(
            $tableColumn['colname'],
            Type::getType($this->_platform->getDoctrineTypeMapping($tableColumn['typename'])),
            []
        );
    }
}
