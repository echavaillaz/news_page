<?php

declare(strict_types=1);

namespace Pint\NewsPage\Domain\Repository;

use GeorgRinger\News\Domain\Repository\NewsDefaultRepository;
use Pint\NewsPage\Domain\Model\NewsPage;

class NewsPageRepository extends NewsDefaultRepository
{
    public function findOneByPageId(int $pageId): ?NewsPage
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $query
            ->matching($query->equals('page', $pageId))
            ->execute()
            ->getFirst();
    }
}
