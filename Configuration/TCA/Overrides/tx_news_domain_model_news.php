<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') === true || die;

(static function () {
    if ($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['label_alt'] !== null) {
        $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['label_alt'] .= ',page';
    } else {
        $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['label_alt'] = 'page';
    }

    ExtensionManagementUtility::addTCAcolumns(
        'tx_news_domain_model_news',
        [
            'back_page' => [
                'config' => [
                    'allowed' => 'pages',
                    'default' => 0,
                    'foreign_table' => 'pages',
                    'internal_type' => 'db',
                    'maxitems' => 1,
                    'size' => 1,
                    'type' => 'group'
                ],
                'exclude' => true,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:back'
            ],
            'page' => [
                'config' => [
                    'allowed' => 'pages',
                    'foreign_table' => 'pages',
                    'internal_type' => 'db',
                    'maxitems' => 1,
                    'minitems' => 1,
                    'readOnly' => true,
                    'size' => 1,
                    'type' => 'group'
                ],
                'exclude' => true,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:page'
            ]
        ]
    );

    unset(
        $GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['paletteDate']['label'],
        $GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['sitemap']['label']
    );
})();
