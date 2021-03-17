<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Pint\NewsPage\Domain\Repository;

use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractRepository
{
    protected ConnectionPool $connectionPool;
    protected QueryBuilder $queryBuilder;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
        $this->queryBuilder = $this->connectionPool->getQueryBuilderForTable(static::TABLE);
        $this->queryBuilder->getRestrictions()->removeAll();
    }

    public function findOneById(int $id, string $fields = '*'): array
    {
        $rows = $this->queryBuilder
            ->select(...GeneralUtility::trimExplode(',', $fields, true))
            ->from(static::TABLE)
            ->where(
                $this->queryBuilder->expr()->eq('uid', $this->queryBuilder->createNamedParameter($id, PDO::PARAM_INT))
            )
            ->execute()
            ->fetchAssociative();

        return $rows === false ? [] : $rows;
    }
}
