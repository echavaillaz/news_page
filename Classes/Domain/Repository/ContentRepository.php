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
