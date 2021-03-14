<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') === true || die;

(static function () {
    ExtensionManagementUtility::addTCAcolumns(
        'tt_content',
        [
            'tx_news_related_news' => [
                'config' => [
                    'type' => 'passthrough'
                ]
            ]
        ]
    );
})();
