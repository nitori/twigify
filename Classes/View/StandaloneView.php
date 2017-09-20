<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 14:25
 */

namespace LFM\Twigify\View;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Mvc\Web\Request as WebRequest;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

class StandaloneView extends AbstractTemplateView
{
    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var \Twig_Template
     */
    protected $twigTemplate;

    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->setRenderingContext($this->objectManager->get(RenderingContext::class));
        $this->setRenderingContext($this->objectManager->get(RenderingContext::class));

        /** @var WebRequest $request */
        $request = $this->objectManager->get(WebRequest::class);
        $request->setRequestURI(GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'));
        $request->setBaseURI(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'));
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($request);
        /** @var ControllerContext $controllerContext */
        $controllerContext = $this->objectManager->get(ControllerContext::class);
        $controllerContext->setRequest($request);
        $controllerContext->setUriBuilder($uriBuilder);
        $this->setControllerContext($controllerContext);
    }

    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function assignMultiple($variables)
    {
        foreach ($variables as $name => $value) {
            $this->assign($name, $value);
        }
    }

    /**
     * @param \Twig_Template $template
     */
    public function setTwigTemplate($template)
    {
        $this->twigTemplate = $template;
    }

    public function render()
    {
        $this->variables['_all'] = $this->variables;
        return $this->twigTemplate->render($this->variables);
    }
}