<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */
defined('TYPO3') === true || die;

(static function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
        @import \'EXT:news_page/Configuration/TsConfig/Page/Mod/web_layout.tsconfig\'
    ');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
        @import \'EXT:news_page/Configuration/TsConfig/User/options.tsconfig\'
    ');

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'apps-pagetree-page-news',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:news_page/Resources/Public/Icons/applications/apps-pagetree-page-news.svg'
        ]
    );
    $iconRegistry->registerIcon(
        'backend-layout-news',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:news_page/Resources/Public/Icons/backend-layouts/backend-layout-news.svg'
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList::class]['modifyQuery'][] =
        \Hemmer\NewsPage\Hooks\DatabaseRecordListHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        \Hemmer\NewsPage\Hooks\DataHandlerHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        \Hemmer\NewsPage\Hooks\DataHandlerHook::class;
})();
