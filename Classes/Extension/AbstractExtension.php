<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 23.02.2016
 * Time: 10:22
 */

namespace LFM\Twigify\Extension;

use LFM\Twigify\TokenParser\WithTokenParser;

abstract class AbstractExtension extends \Twig_Extension
{
    /**
     * @var \LFM\Twigify\View\AbstractTemplateView
     */
    protected $view;

    public function __construct($view) {
        $this->view = $view;
    }

    public function getTokenParsers()
    {
        return [
            new WithTokenParser(),
        ];
    }
}