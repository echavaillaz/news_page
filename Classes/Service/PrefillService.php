<?php

declare(strict_types=1);

namespace Pint\NewsPage\Service;

use GeorgRinger\News\Domain\Model\Dto\EmConfiguration;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function strtotime;

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
