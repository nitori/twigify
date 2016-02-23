<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 12:54
 */

namespace LFM\Twigify\Filters;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

abstract class AbstractFilter extends \Twig_SimpleFilter
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

        $className = array_pop(explode('\\', get_class($this)));
        $classBaseName = substr($className, 0, strlen($className)-6);
        $classBaseName = GeneralUtility::camelCaseToLowerCaseUnderscored($classBaseName);
        parent::__construct($classBaseName, array($this, 'render'), $options);
    }

    /**
     * Return an instance of ImageService
     *
     * @return ImageService
     */
    protected function getImageService()
    {
        return $this->objectManager->get(ImageService::class);
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
}