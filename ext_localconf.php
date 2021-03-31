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

    $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['news']['contentElementRelation'] = true;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/class.db_list_extra.inc']['actions'][] =
        \Pint\NewsPage\Hooks\DatabaseRecordListHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/class.db_list_extra.inc']['getTable'][] =
        \Pint\NewsPage\Hooks\DatabaseRecordListHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        \Pint\NewsPage\Hooks\DataHandlerHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        \Pint\NewsPage\Hooks\DataHandlerHook::class;

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\ContextMenu\ItemProviders\RecordProvider::class]['className'] =
        \Pint\NewsPage\XClass\ContextMenu\RecordProviderXClass::class;
})();
