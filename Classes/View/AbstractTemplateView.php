<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 14:27
 */

namespace LFM\Twigify\View;


abstract class AbstractTemplateView
{

    /**
     * @var \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext
     */
    protected $controllerContext;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * The initial rendering context for this template view.
     * Due to the rendering stack, another rendering context might be active
     * at certain points while rendering the template.
     *
     * @var \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface
     */
    protected $baseRenderingContext;

    /**
     * @var \Twig_LoaderInterface
     */
    protected $twigLoader;

    /**
     * @var \Twig_Environment
     */
    protected $twigEnvironment;

    /**
     * @return \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    public function getObjectManager() {
        return $this->objectManager;
    }

    /**
     * @return \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface
     */
    public function getRenderingContext()
    {
        return $this->baseRenderingContext;
    }

    /**
     * @param \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     */
    public function setRenderingContext(\TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        $this->baseRenderingContext = $renderingContext;
        $this->controllerContext = $renderingContext->getControllerContext();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext
     */
    public function getControllerContext()
    {
        return $this->controllerContext;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext $controllerContext
     */
    public function setControllerContext($controllerContext)
    {
        $this->controllerContext = $controllerContext;
    }
}