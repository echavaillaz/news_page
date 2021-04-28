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

namespace Pint\NewsPage\Hooks;

use Pint\NewsPage\Domain\Repository\PageRepository;
use function is_array;
use Psr\Http\Message\ServerRequestInterface;
use function reset;
use TYPO3\CMS\Backend\Controller\PageLayoutController;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class DrawHeaderHook
{
    protected array $pageRecord = [];
    protected StandaloneView $view;

    public function __construct(StandaloneView $view)
    {
        $this->view = $view;
        $this->view->setTemplatePathAndFilename($this->getTemplatePath());
    }

    public function render(
        /** @noinspection PhpUnusedParameterInspection */
        array $parameters,
        PageLayoutController $pageLayoutController
    ): string {
        /** @noinspection PhpInternalEntityUsedInspection */
        if ($this->isNewsPageRecord($pageLayoutController->pageinfo) === false) {
            return '';
        }

        $this->pageRecord = $this->getPageRecord($pageLayoutController);

        return $this->view
            ->assignMultiple([
                'editUrl' => $this->getEditUrl(),
                'title' => $this->pageRecord['title']
            ])
            ->render();
    }

    protected function getEditUrl(): string
    {
        return (string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute(
            'record_edit',
            [
                'columnsOnly' => 'news',
                'edit' => [
                    'pages' => [
                        $this->pageRecord['uid'] => 'edit'
                    ]
                ],
                'returnUrl' => $this->getRequest()->getAttribute('normalizedParams')->getRequestUri()
            ]
        );
    }

    protected function getPageRecord(PageLayoutController $pageLayoutController): array
    {
        /** @noinspection PhpInternalEntityUsedInspection */
        $language = (int)$pageLayoutController->MOD_SETTINGS['language'];

        if ($language === 0) {
            /** @noinspection PhpInternalEntityUsedInspection */
            return $pageLayoutController->pageinfo;
        }

        if ($language > 0) {
            /** @noinspection PhpInternalEntityUsedInspection */
            $localizedPage = BackendUtility::getRecordLocalization('pages', $pageLayoutController->id, $language);

            if (is_array($localizedPage) === true) {
                return reset($localizedPage);
            }
        }

        return [];
    }

    protected function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    protected function getTemplatePath(): string
    {
        return ExtensionManagementUtility::extPath('mr_news_page')
            . 'Resources/Private/Templates/PageLayout/Header.html';
    }

    protected function isNewsPageRecord(array $pageRecord): bool
    {
        return $pageRecord['doktype'] === PageRepository::DOKTYPE_NEWS && $pageRecord['news'] > 0;
    }
}
