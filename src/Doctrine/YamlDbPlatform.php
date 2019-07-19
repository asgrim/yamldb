<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use LogicException;

final class YamlDbPlatform extends AbstractPlatform
{
    /** @param mixed[] $columnDef */
    public function getBooleanTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /** @param mixed[] $columnDef */
    public function getIntegerTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /** @param mixed[] $columnDef */
    public function getBigIntTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /** @param mixed[] $columnDef */
    public function getSmallIntTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /** @param mixed[] $columnDef */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef) : string // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    protected function initializeDoctrineTypeMappings() : void
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /** @param mixed[] $field */
    public function getClobTypeDeclarationSQL(array $field) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    /** @param mixed[] $field */
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
