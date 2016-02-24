<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 13:02
 */

namespace LFM\Twigify\Twigs;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class RteTwig extends AbstractTwig
{

    /**
     * @param $value string
     * @return string
     */
    public function render($value) {
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $content = $contentObject->parseFunc($value, array(), '< lib.parseFunc_RTE');
        return new \Twig_Markup($content, $GLOBALS['TSFE']->renderCharset);
    }
}