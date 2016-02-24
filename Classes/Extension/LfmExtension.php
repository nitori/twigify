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

    public function initialiseTwigs() {
        $this->twigs = [
            'debug' => \LFM\Twigify\Twigs\DebugTwig::class,
            'typolink' => \LFM\Twigify\Twigs\TypolinkTwig::class,
            'rte' => \LFM\Twigify\Twigs\RteTwig::class,
            'l' => \LFM\Twigify\Twigs\LTwig::class,
            'get_url' => \LFM\Twigify\Twigs\GetUrlTwig::class,
            'media' => \LFM\Twigify\Twigs\MediaTwig::class,
            'page_info' => \LFM\Twigify\Twigs\PageInfoTwig::class,
        ];
    }

    public function getDebugArguments() {
        if(is_object($this->twigs['debug'])) {
            return $this->twigs['debug']->getDebugArguments();
        }
        return [];
    }
}