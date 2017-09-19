<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 23.02.2016
 * Time: 14:08
 */

namespace LFM\Twigify\Twigs;

abstract class AbstractTwig implements TwigInterface
{
    /**
     * @var \LFM\Twigify\View\AbstractTemplateView
     */
    protected $view;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface
     */
    protected $renderingContext;

    /**
     * @param $view \LFM\Twigify\View\AbstractTemplateView
     * @param $options array
     */
    public function __construct($view, array $options = []) {
        $this->view = $view;
        $this->objectManager = $this->view->getObjectManager();
    }

    /**
     * @return \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface
     */
    public function getRenderingContext()
    {
        return $this->renderingContext;
    }

    /**
     * @param \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     */
    public function setRenderingContext($renderingContext)
    {
        $this->renderingContext = $renderingContext;
    }

    public function __toString() {
        return '<'.get_class($this).'>';
    }
}