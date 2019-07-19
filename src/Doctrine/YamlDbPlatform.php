<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use LogicException;

final class YamlDbPlatform extends AbstractPlatform
{
    /**
     * Returns the SQL snippet that declares a boolean column.
     *
     * @param mixed[] $columnDef
     */
    public function getBooleanTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the SQL snippet that declares a 4 byte integer column.
     *
     * @param mixed[] $columnDef
     */
    public function getIntegerTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the SQL snippet that declares an 8 byte integer column.
     *
     * @param mixed[] $columnDef
     */
    public function getBigIntTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the SQL snippet that declares a 2 byte integer column.
     *
     * @param mixed[] $columnDef
     */
    public function getSmallIntTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the SQL snippet that declares common properties of an integer column.
     *
     * @param mixed[] $columnDef
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Lazy load Doctrine Type Mappings.
     */
    protected function initializeDoctrineTypeMappings() : void
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the SQL snippet used to declare a CLOB column type.
     *
     * @param mixed[] $field
     */
    public function getClobTypeDeclarationSQL(array $field) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Returns the SQL Snippet used to declare a BLOB column type.
     *
     * @param mixed[] $field
     */
    public function getBlobTypeDeclarationSQL(array $field) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /**
     * Gets the name of the platform.
     */
    public function getName() : string
    {
        return 'yamldb';
    }
}
