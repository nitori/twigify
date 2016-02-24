<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 24.02.2016
 * Time: 11:03
 */

namespace LFM\Twigify\Environment;

class LfmEnvironment extends \Twig_Environment
{

    protected function getFilterOrFunction($name, $funcName) {
        $filter = false;
        foreach($this->extensions as $extension) {
            $methods = get_class_methods(get_class($extension));
            if(in_array($funcName, $methods)) {
                $filter = $extension->$funcName($name);
                if($filter) {
                    break;
                }
            }
        }
        return is_null($filter) ? false : $filter;
    }

    public function getFilter($name) {
        $filter = parent::getFilter($name);
        if(!$filter) {
            $filter = $this->getFilterOrFunction($name, 'getFilter');
        }
        return is_null($filter) ? false : $filter;
    }

    public function getFunction($name) {
        $filter = parent::getFunction($name);
        if(!$filter) {
            $filter = $this->getFilterOrFunction($name, 'getFunction');
        }
        return is_null($filter) ? false : $filter;
    }
}