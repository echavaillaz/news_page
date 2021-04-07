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
use TYPO3\CMS\Backend\RecordList\RecordListGetTableHookInterface;
use TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface;

class DatabaseRecordListHook implements RecordListGetTableHookInterface, RecordListHookInterface
{
    public function getDBlistQuery($table, $pageId, &$additionalWhereClause, &$selectedFieldsList, &$parentObject): void
    {
        if ($this->isNewsPageRecord($table, $parentObject->pageRecord) === true) {
            $parentObject->clickTitleMode = '';
            $parentObject->deniedNewTables[] = 'tx_news_domain_model_news';
            $parentObject->disableSingleTableView = true;
        }
    }

    public function makeClip($table, $row, $cells, &$parentObject): array
    {
        if ($this->isNewsPageRecord($table, $parentObject->pageRecord) === true) {
            $parentObject->selFieldList .= ',page';

            foreach ($cells as $action => $_) {
                $cells[$action] = $parentObject->spaceIcon;
            }
        }

        return $cells;
    }

    public function makeControl($table, $row, $cells, &$parentObject): array
    {
        if ($this->isNewsPageRecord($table, $parentObject->pageRecord) === true) {
            $parentObject->selFieldList .= ',page';

            foreach ($cells as $action => $_) {
                if ($action === 'delete' || $action === 'edit' || $action === 'hide' || $action === 'new') {
                    $cells[$action] = $parentObject->spaceIcon;
                }
            }
        }

        return $cells;
    }

    public function renderListHeader($table, $currentIdList, $headerColumns, &$parentObject): array
    {
        return $headerColumns;
    }

    public function renderListHeaderActions($table, $currentIdList, $cells, &$parentObject): array
    {
        return $cells;
    }

    protected function isNewsPageRecord(string $table, array $pageRecord = null): bool
    {
        if ($pageRecord === null) {
            return false;
        }

        return $table === 'tx_news_domain_model_news'
            && $pageRecord['doktype'] === PageRepository::DOKTYPE_NEWS
            && $pageRecord['news'] > 0;
    }
}
