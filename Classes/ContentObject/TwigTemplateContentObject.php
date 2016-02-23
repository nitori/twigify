<?php

namespace LFM\Twigify\ContentObject;

use LFM\Twigify\Extension\LfmExtension;
use LFM\Twigify\Extension\WithExtension;
use LFM\Twigify\Filters as F;

use LFM\Twigify\View\StandaloneView;
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
        $variables['_all'] = $variables;

        $templatePaths = [];
        foreach($conf['templateRootPaths.'] as $path) {
            if(trim($path)) {
                $templatePaths[] = GeneralUtility::getFileAbsFileName($path);
            }
        }
        foreach($conf['rootPaths.'] as $path) {
            if(trim($path)) {
                $templatePaths[] = GeneralUtility::getFileAbsFileName($path);
            }
        }

        $loader = new \Twig_Loader_Filesystem($templatePaths);
        $twig = new \Twig_Environment($loader, [
            //'cache' => GeneralUtility::getFileAbsFileName('typo3temp/Cache/Code/twig_template'),
            'auto_reload' => true,
        ]);

        $lfmExtension = new LfmExtension($view);
        $twig->addExtension($lfmExtension);
        $twig->addExtension(new WithExtension($view));

        $format = $conf['format'] ? $conf['format'] : 'twig';
        $template = $twig->loadTemplate($conf['templateName'].'.'.$format);
        $source = $template->render($variables);

        foreach($lfmExtension->getDebugArguments() as $arguments) {
            DebuggerUtility::var_dump(...$arguments);
        }

        return $source;
    }
}
