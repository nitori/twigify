<?php

namespace LFM\Twigify\ContentObject;

use LFM\Twigify\Extension\LfmExtension;

use LFM\Twigify\Template\LfmTemplate;
use LFM\Twigify\View\StandaloneView;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\FluidTemplateContentObject;

class TwigTemplateContentObject extends FluidTemplateContentObject
{
    /**
     * @param array $conf
     * @return string
     */
    public function render($conf = [])
    {
        if (!is_array($conf)) {
            $conf = [];
        }

        $view = new StandaloneView();
        $variables = $this->getContentObjectVariables($conf);
        $variables = $this->contentDataProcessor->process($this->cObj, $conf, $variables);

        $templatePaths = [];
        if(is_array($conf['templateRootPaths.'])) {
            foreach ($conf['templateRootPaths.'] as $path) {
                if (trim($path)) {
                    $templatePaths[] = GeneralUtility::getFileAbsFileName($path);
                }
            }
        }

        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
        /** @var \TYPO3\CMS\Core\Cache\Frontend\PhpFrontend $cacheInstance */
        $cacheInstance = $cacheManager->getCache('twigify');
        /** @var \TYPO3\CMS\Core\Cache\Backend\FileBackend $backend */
        $backend = $cacheInstance->getBackend();

        $loader = new \Twig_Loader_Filesystem($templatePaths);
        $twig = new \Twig_Environment($loader, [
            'cache' => $backend->getCacheDirectory(),
            'auto_reload' => true,
            'base_template_class' => LfmTemplate::class,
        ]);

        $lfmExtension = new LfmExtension();
        $lfmExtension->setView($view);
        $lfmExtension->initialiseTwigs();

        $twig->addExtension($lfmExtension);

        $format = $conf['format'] ? $conf['format'] : 'twig';
        $template = $twig->loadTemplate($conf['templateName'].'.'.$format);

        $variables['_all'] = $variables;
        $source = $template->render($variables);

        foreach($lfmExtension->getDebugArguments() as $arguments) {
            DebuggerUtility::var_dump(...$arguments);
        }

        return $source;
    }
}
