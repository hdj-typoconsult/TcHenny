<?php

defined('TYPO3_MODE') || die('Access denied.');

(function () {
    $extKey = 'tc_henny';
    $labelPrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:';
    $extConf = \TYPOCONSULT\TcSys\Utility\CommonUtility::getExtensionConfiguration($extKey);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'TcHenny',
        'Plugin',
        [\TYPOCONSULT\TcHenny\Controller\PluginController::class => 'show'],
        [],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    $wizardItemsTab = 'plugins';
    if ($extConf['wizardItemsTab']) {
        $wizardItemsTab = $extConf['wizardItemsTab'];
    }

    $pluginName = 'tchenny_plugin';

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
})();