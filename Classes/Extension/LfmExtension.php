<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 22.02.2016
 * Time: 16:34
 */

namespace LFM\Twigify\Extension;
use LFM\Twigify\Filters as F;

class LfmExtension extends AbstractExtension
{
    /**
     * @var \LFM\Twigify\Filters\DebugFilter
     */
    protected $debugFilter;

    public function __construct($view) {
        parent::__construct($view);
        $this->debugFilter = new F\DebugFilter($this->view);
    }

    public function getName()
    {
        return 'lfm';
    }

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('page', [$this, 'getPageData']),
        ];
    }

    public function getFilters() {
        return [
            $this->debugFilter,
            new F\MediaFilter($this->view),
            new F\RteFilter($this->view),
            new F\GetUrlFilter($this->view),
            new F\LFilter($this->view),
        ];
    }

    public function getPageData($uid=null) {

    }

    public function getDebugArguments() {
        return $this->debugFilter->getDebugArguments();
    }
}