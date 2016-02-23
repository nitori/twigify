<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 12:54
 */

namespace LFM\Twigify\Filters;


class DebugFilter extends AbstractFilter
{
    protected $debugArguments = [];

    public function render(...$args) {
        $this->addDebugArguments(...$args);
    }

    public function addDebugArguments(...$args) {
        $this->debugArguments[] = $args;
    }

    public function getDebugArguments() {
        return $this->debugArguments;
    }
}