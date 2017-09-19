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

    public function getTwigs() {
        foreach ($this->twigs as $name => $twig) {
            if (is_string($this->twigs[$name])) {
                $this->twigs[$name] = new $this->twigs[$name]($this->view);
            }
        }
        return $this->twigs;
    }

    public function getFilters()
    {
        $filters = [];
        foreach ($this->getTwigs() as $name => $twig) {
            $filters[] = new \Twig_Filter($name, [$twig, 'render']);
        }
        return $filters;
    }

    public function getFunctions() {
        $filters = [];
        foreach ($this->getTwigs() as $name => $twig) {
            $filters[] = new \Twig_Function($name, [$twig, 'render']);
        }
        return $filters;
    }
}