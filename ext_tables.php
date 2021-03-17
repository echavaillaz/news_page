<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */
defined('TYPO3') === true || die;

(static function () {
    $GLOBALS['PAGES_TYPES'][\Pint\NewsPage\Domain\Repository\PageRepository::DOKTYPE_NEWS] = [
        'allowedTables' => '*'
    ];
})();
