<?php

declare(strict_types=1);

namespace Asgrim\YamlDb\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use LogicException;

final class YamlDbPlatform extends AbstractPlatform
{
    public function getBooleanTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    public function getIntegerTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    public function getBigIntTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    public function getSmallIntTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    protected function initializeDoctrineTypeMappings() : void
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

    public function getClobTypeDeclarationSQL(array $field) : string
    {
        throw new LogicException('Not implemented yet: ' . __METHOD__);
    }

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
