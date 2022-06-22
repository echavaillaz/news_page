<?php

declare(strict_types=1);

namespace Pint\NewsPage\Domain\Repository;

use PDO;

class ContentRepository extends AbstractRepository
{
    protected const TABLE = 'tt_content';

    public function findAllByPageId(int $pageId): array
    {
        return $this->queryBuilder
            ->select('uid')
            ->from(self::TABLE)
            ->where(
                $this->queryBuilder->expr()->eq(
                    'pid',
                    $this->queryBuilder->createNamedParameter($pageId, PDO::PARAM_INT)
                )
            )
            ->orderBy('sorting')
            ->execute()
            ->fetchFirstColumn();
    }
}
