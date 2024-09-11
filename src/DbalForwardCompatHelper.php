<?php

declare(strict_types=1);

namespace Broadway\EventStore\Dbal;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;

class DbalForwardCompatHelper
{
    public static function getSchemaManagerAndSchema(Connection $connection): array
    {
        if (method_exists($connection, 'getSchemaManager')) {
            $schemaManager = $connection->getSchemaManager();
            $schema = $schemaManager->createSchema();
        } else {
            $schemaManager = $connection->createSchemaManager();
            $schema = $schemaManager->introspectSchema();
        }

        return [$schemaManager, $schema];
    }

    /**
     * @return int|ArrayParameterType
     */
    public static function getParamStrArrayConst()
    {
        return defined('\Doctrine\DBAL\Connection::PARAM_STR_ARRAY')
            ? Connection::PARAM_STR_ARRAY : ArrayParameterType::STRING;
    }
}
