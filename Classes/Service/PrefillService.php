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

namespace Hemmer\NewsPage\Service;

use GeorgRinger\News\Domain\Model\Dto\EmConfiguration;
use function strtotime;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PrefillService
{
    protected array $backendUser = [];
    protected array $pageTsConfig = [];

    public function __construct(int $pageId)
    {
        $this->backendUser = $this->getBackendUser();
        $this->pageTsConfig = $this->getPageTsConfig($pageId);
    }

    public function getArchive(): int
    {
        return (int)strtotime((string)$this->pageTsConfig['archive']);
    }

    public function getAuthor(): string
    {
        return (bool)$this->pageTsConfig['author'] === true ? $this->backendUser['realName'] : '';
    }

    public function getAuthorEmail(): string
    {
        return (bool)$this->pageTsConfig['author'] === true ? $this->backendUser['email'] : '';
    }

    public function getDatetime(): int
    {
        return GeneralUtility::makeInstance(EmConfiguration::class)->getDateTimeRequired() === true
            ? (int)GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('date', 'timestamp')
            : 0;
    }

    protected function getBackendUser(): array
    {
        return $GLOBALS['BE_USER']->user;
    }

    protected function getPageTsConfig(int $pageId = 0): array
    {
        $pageTsConfig = BackendUtility::getPagesTSconfig($pageId);

        return (array)$pageTsConfig['tx_news.']['predefine.'];
    }
}
