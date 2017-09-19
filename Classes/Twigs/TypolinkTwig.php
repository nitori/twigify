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

class TypolinkTwig extends AbstractTwig
{
    /**
     * @param mixed $parameter
     * @param array $configuration
     * @return string
     */
    public function render($parameter, $configuration=[]) {
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject */
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $configuration['parameter'] = $parameter;
        return $contentObject->typoLink_URL($configuration);
    }
}