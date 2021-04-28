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

namespace Pint\NewsPage\DataProcessing;

use Pint\NewsPage\Domain\Model\NewsPage;
use Pint\NewsPage\Domain\Repository\NewsPageRepository;
use Pint\NewsPage\Domain\Repository\PageRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class NewsPageProcessor implements DataProcessorInterface
{
    protected NewsPageRepository $newsPageRepository;

    public function __construct(NewsPageRepository $newsPageRepository)
    {
        $this->newsPageRepository = $newsPageRepository;
    }

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if ($processedData['data']['doktype'] !== PageRepository::DOKTYPE_NEWS) {
            return $processedData;
        }

        $processedData['newsItem'] = $this->getNewsItem($this->getPageId($processedData['data']));

        return $processedData;
    }

    protected function getNewsItem(int $pageId): ?NewsPage
    {
        return $this->newsPageRepository->findOneByPageId($pageId);
    }

    protected function getPageId(array $pageRecord): int
    {
        return $pageRecord['sys_language_uid'] === 0 ? $pageRecord['uid'] : $pageRecord['_PAGES_OVERLAY_UID'];
    }
}
