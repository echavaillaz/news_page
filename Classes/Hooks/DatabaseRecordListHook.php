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

namespace Hemmer\NewsPage\Hooks;

use Hemmer\NewsPage\Domain\Repository\PageRepository;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DatabaseRecordListHook
{
    protected static int $count = 0;
    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function modifyQuery(
        /** @noinspection PhpUnusedParameterInspection */
        array $parameters,
        string $table,
        int $pageId,
        array $additionalConstraints,
        array $fieldList,
        QueryBuilder $queryBuilder
    ): void {
        if ($pageId > 0 && $table === 'tx_news_domain_model_news') {
            $page = $this->pageRepository->findOneById($pageId, 'doktype');

            if ($page['doktype'] === PageRepository::DOKTYPE_NEWS) {
                $queryBuilder->where(...['1=2']);

                if (self::$count === 0 && $this->getRoutePath() === '/module/web/list') {
                    $this->addFlashMessage();
                }

                ++self::$count;
            }
        }
    }

    protected function addFlashMessage(): void
    {
        GeneralUtility::makeInstance(FlashMessageService::class)->getMessageQueueByIdentifier()->enqueue(
            GeneralUtility::makeInstance(
                FlashMessage::class,
                $this->translate('hidden_news_records'),
                '',
                FlashMessage::INFO
            )
        );
    }

    protected function getLanguagePath(): string
    {
        return 'LLL:EXT:news_page/Resources/Private/Language/locallang_be.xlf:';
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    protected function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    protected function getRoutePath(): string
    {
        return $this->getRequest()->getAttribute('routePath');
    }

    protected function translate(string $label): string
    {
        return $this->getLanguageService()->sL($this->getLanguagePath() . $label);
    }
}
