<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') === true || die;

(static function () {
    ExtensionManagementUtility::addStaticFile('news_page', 'Configuration/TypoScript/', 'News Page');
})();
