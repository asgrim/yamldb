<?php
declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class YamlDbPlatform extends AbstractPlatform
{
    /**
     * Returns the SQL snippet that declares a boolean column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
        // TODO: Implement getBooleanTypeDeclarationSQL() method.
    }

    /**
     * Returns the SQL snippet that declares a 4 byte integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
        // TODO: Implement getIntegerTypeDeclarationSQL() method.
    }

    /**
     * Returns the SQL snippet that declares an 8 byte integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
        // TODO: Implement getBigIntTypeDeclarationSQL() method.
    }

    /**
     * Returns the SQL snippet that declares a 2 byte integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
        // TODO: Implement getSmallIntTypeDeclarationSQL() method.
    }

    /**
     * Returns the SQL snippet that declares common properties of an integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        // TODO: Implement _getCommonIntegerTypeDeclarationSQL() method.
    }

    /**
     * Lazy load Doctrine Type Mappings.
     *
     * @return void
     */
    protected function initializeDoctrineTypeMappings()
    {
        // TODO: Implement initializeDoctrineTypeMappings() method.
    }

    /**
     * Returns the SQL snippet used to declare a CLOB column type.
     *
     * @param mixed[] $field
     *
     * @return string
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
        // TODO: Implement getClobTypeDeclarationSQL() method.
    }

    /**
     * Returns the SQL Snippet used to declare a BLOB column type.
     *
     * @param mixed[] $field
     *
     * @return string
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        // TODO: Implement getBlobTypeDeclarationSQL() method.
    }

    /**
     * Gets the name of the platform.
     *
     * @return string
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }
}
