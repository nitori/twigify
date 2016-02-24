<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 23.02.2016
 * Time: 10:19
 */

namespace LFM\Twigify\Extension;

use LFM\Twigify\TokenParser\WithTokenParser;

class WithExtension extends AbstractExtension
{

    public function getName()
    {
        return 'with';
    }

    public function getTokenParsers()
    {
        return [
            new WithTokenParser(),
        ];
    }
}