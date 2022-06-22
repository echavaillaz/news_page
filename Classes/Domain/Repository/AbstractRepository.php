<?php

declare(strict_types=1);

namespace Pint\NewsPage\Domain\Repository;

use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractRepository
{
    protected QueryBuilder $queryBuilder;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->queryBuilder = $connectionPool->getQueryBuilderForTable(static::TABLE);
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
