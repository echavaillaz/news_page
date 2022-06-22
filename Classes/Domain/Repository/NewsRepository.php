<?php

declare(strict_types=1);

namespace Pint\NewsPage\Domain\Repository;

use PDO;

class NewsRepository extends AbstractRepository
{
    protected const TABLE = 'tx_news_domain_model_news';

    public function findOneByPageId(int $pageId): int
    {
        return (int)$this->queryBuilder
            ->select('uid')
            ->from(self::TABLE)
            ->where(
                $this->queryBuilder->expr()->eq(
                    'page',
                    $this->queryBuilder->createNamedParameter($pageId, PDO::PARAM_INT)
                )
            )
            ->execute()
            ->fetchOne();
    }
}
