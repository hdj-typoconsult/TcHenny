<?php

defined('TYPO3_MODE') || die('Access denied.');

(function () {
    $extKey = 'tc_base';
    $labelPrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:';
    $extConf = \TYPOCONSULT\TcSys\Utility\CommonUtility::getExtensionConfiguration($extKey);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'TcBase',
        'Plugin',
        [\TYPOCONSULT\TcBase\Controller\PluginController::class => 'show'],
        [],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    $wizardItemsTab = 'plugins';
    if ($extConf['wizardItemsTab']) {
        $wizardItemsTab = $extConf['wizardItemsTab'];
    }

    $pluginName = 'tcbase_plugin';

    // Add plugin to wizardItems
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '
        mod {
            wizards {
                newContentElement {
                    wizardItems {
                        ' . $wizardItemsTab . ' {
                            elements {
                                ' . $pluginName . ' {
                                    title = ' . $labelPrefix . 'tt_content.' . $pluginName . '.name
                                    description = ' . $labelPrefix . 'tt_content.' . $pluginName . '.description
                                    tt_content_defValues {
                                        CType = ' . $pluginName . '
                                    }
                                }
                            }
                            
                            show := addToList(' . $pluginName . ')
                        }
                    }
                }
            }
        }
        '
    );

    // Adding various hooks
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tc_sys']['addAdditionalPreview'][] = \TYPOCONSULT\TcBase\Hooks\VoilaHook::class . '->addAdditionalPreview';
})();