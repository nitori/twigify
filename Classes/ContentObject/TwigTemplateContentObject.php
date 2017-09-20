<?php

namespace LFM\Twigify\ContentObject;

use LFM\Twigify\Extension\LfmExtension;
use LFM\Twigify\Template\LfmTemplate;
use LFM\Twigify\View\StandaloneView;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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

        $variables = $this->getContentObjectVariables($conf);
        $variables = $this->contentDataProcessor->process($this->cObj, $conf, $variables);

        $templatePaths = [];
        if (is_array($conf['templateRootPaths.'])) {
            foreach ($conf['templateRootPaths.'] as $path) {
                if (trim($path)) {
                    $templatePaths[] = GeneralUtility::getFileAbsFileName($path);
                }
            }
        }
        $macroPaths = [];
        if (is_array($conf['macroRootPaths.'])) {
            foreach ($conf['macroRootPaths.'] as $path) {
                if (trim($path)) {
                    $macroPaths[] = GeneralUtility::getFileAbsFileName($path);
                }
            }
        }
        $layoutPaths = [];
        if (is_array($conf['layoutRootPaths.'])) {
            foreach ($conf['layoutRootPaths.'] as $path) {
                if (trim($path)) {
                    $layoutPaths[] = GeneralUtility::getFileAbsFileName($path);
                }
            }
        }

        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
        /** @var \TYPO3\CMS\Core\Cache\Frontend\PhpFrontend $cacheInstance */
        $cacheInstance = $cacheManager->getCache('twigify');
        /** @var \TYPO3\CMS\Core\Cache\Backend\FileBackend $backend */
        $backend = $cacheInstance->getBackend();

        $loader = new FilesystemLoader($templatePaths);
        $loader->setPaths($macroPaths, 'macro');
        $loader->setPaths($layoutPaths, 'layout');

        $twig = new Environment($loader, [
            //'cache' => $backend->getCacheDirectory(),
            'auto_reload' => true,
            'base_template_class' => LfmTemplate::class,
        ]);

        $this->view = new StandaloneView($twig, [
            GeneralUtility::makeInstance(LfmExtension::class),
        ]);

        $format = $conf['format'] ? $conf['format'] : 'twig';
        $template = $twig->loadTemplate($conf['templateName'].'.'.$format);

        $this->view->setTwigTemplate($template);
        $this->view->assignMultiple($variables);
        $this->assignSettings($conf);

        $source = $this->view->render();

        return $source;
    }
}
