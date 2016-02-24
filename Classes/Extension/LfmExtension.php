<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 22.02.2016
 * Time: 16:34
 */

namespace LFM\Twigify\Extension;

class LfmExtension extends AbstractExtension
{

    public function __construct() {
        $this->twigs = [
            'rte' => \LFM\Twigify\Twigs\RteTwig::class,
            'l' => \LFM\Twigify\Twigs\LTwig::class,
            'get_url' => \LFM\Twigify\Twigs\GetUrlTwig::class,
            'media' => \LFM\Twigify\Twigs\MediaTwig::class,
            'debug' => \LFM\Twigify\Twigs\DebugTwig::class,
            'page_info' => \LFM\Twigify\Twigs\PageInfoTwig::class,
        ];
    }

    public function getName()
    {
        return 'lfm';
    }

    public function getDebugArguments() {
        if(is_object($this->twigs['debug'])) {
            return $this->twigs['debug']->getDebugArguments();
        }
        return [];
    }
}