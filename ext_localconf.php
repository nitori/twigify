<?php
defined('TYPO3_MODE') or die();

// Register all available content objects
$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects'] = array_merge($GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects'], array(
    'TWIGTEMPLATE'    => \LFM\Twigify\ContentObject\TwigTemplateContentObject::class,
));

// Register cache frontend for proxy class generation
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['twigify'] = [
    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\PhpFrontend::class,
    'backend' => \TYPO3\CMS\Core\Cache\Backend\FileBackend::class,
    'groups' => [
        'all',
        'system',
    ],
    'options' => [
        'defaultLifetime' => 0,
    ]
];
