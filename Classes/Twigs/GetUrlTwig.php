<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 13:02
 */

namespace LFM\Twigify\Twigs;


class GetUrlTwig extends AbstractTwig
{
    /**
     * @param $file \TYPO3\CMS\Core\Resource\FileInterface
     * @return string
     */

    public function render(\TYPO3\CMS\Core\Resource\FileInterface $file) {
        $imageService = $this->getImageService();
        return $imageService->getImageUri($file);
    }
}