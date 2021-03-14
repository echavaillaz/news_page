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

namespace Hemmer\NewsPage\Domain\Repository;

use GeorgRinger\News\Domain\Repository\NewsDefaultRepository;
use Hemmer\NewsPage\Domain\Model\NewsPage;

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
