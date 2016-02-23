<?php
namespace LFM\Twigify\View;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Compatibility\TemplateParserBuilder;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Fluid;

/**
 * The main template view. Should be used as view if you want Fluid Templating
 *
 * @api
 */
class TemplateView extends AbstractTemplateView
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->twigLoader = new \Twig_Loader_Filesystem();
        $this->twigEnvironment = new \Twig_Environment($this->twigLoader);
        
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->setRenderingContext($this->objectManager->get(RenderingContextInterface::class));
    }

    /**
     * Init view
     */
    public function initializeView()
    {
    }

}
