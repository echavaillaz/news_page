<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */
defined('TYPO3') === true || die;

(static function () {
    $GLOBALS['PAGES_TYPES'][\Hemmer\NewsPage\Domain\Repository\PageRepository::DOKTYPE_NEWS] = [
        'allowedTables' => '*'
    ];
})();
