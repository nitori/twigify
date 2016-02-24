<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 23.02.2016
 * Time: 10:22
 */

namespace LFM\Twigify\Extension;

use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractExtension extends \Twig_Extension
{
    /**
     * @var \LFM\Twigify\View\AbstractTemplateView
     */
    protected $view;

    /**
     * @var \LFM\Twigify\Twigs\TwigInterface
     */
    protected $twigs;

    public function getName() {
        $classParts = explode('\\', get_class($this));
        $className = GeneralUtility::camelCaseToLowerCaseUnderscored(array_pop($classParts));
        $firstParts = array_slice(explode('_', $className), 0, -1);
        return GeneralUtility::underscoredToLowerCamelCase(implode('_', $firstParts));
    }

    public function setView(\LFM\Twigify\View\AbstractTemplateView $view) {
        $this->view = $view;
    }

    public function getView() {
        return $this->view;
    }

    public function initialiseTwigs() {
    }

    public function getTwig($name) {
        if(!isset($this->twigs[$name])) {
            return false;
        }
        if(is_string($this->twigs[$name])) {
            $this->twigs[$name] = new $this->twigs[$name]($this->view);
        }
        return $this->twigs[$name];
    }

    public function getFilter($name) {
        $twig = $this->getTwig($name);
        if($twig) {
            return new \Twig_SimpleFilter($name, [$twig, 'render']);
        }
        return false;
    }

    public function getFunction($name) {
        $twig = $this->getTwig($name);
        if($twig) {
            return new \Twig_SimpleFunction($name, [$twig, 'render']);
        }
        return false;
    }
}