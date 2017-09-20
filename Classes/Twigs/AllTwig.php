<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 12:54
 */

namespace LFM\Twigify\Twigs;


class AllTwig extends AbstractTwig
{
    public function render() {
        return $this->twigContext;
    }
}