<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 13:02
 */

namespace LFM\Twigify\Twigs;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Extbase\Service\ImageService;

class MediaTwig extends AbstractTwig
{

    /**
     * @param $file \TYPO3\CMS\Core\Resource\FileInterface
     * @param int $width
     * @param int $height
     * @param string $alt
     * @param string $title
     * @return string
     */
    public function render(FileInterface $file, $width=null, $height=null, $alt='', $title='') {

        $crop = $file instanceof FileReference ? $file->getProperty('crop') : null;
        $processingInstructions = array(
            'width' => $width,
            'height' => $height,
            'crop' => $crop,
        );
        $imageService = $this->getImageService();
        $processedImage = $imageService->applyProcessingInstructions($file, $processingInstructions);
        $imageUri = $imageService->getImageUri($processedImage);

        $attributes = [];

        $attributes['src'] = $imageUri;
        $attributes['width'] = $processedImage->getProperty('width');
        $attributes['height'] = $processedImage->getProperty('height');
        $attributes['alt'] = $file->getProperty('alternative');

        $tmp_title = $file->getProperty('title');
        if($tmp_title) {
            $attributes['title'] = $tmp_title;
        }

        // override if passed explicitly
        if($alt) {
            $attributes['alt'] = $alt;
        }
        if($title) {
            $attributes['title'] = $title;
        }

        $tag = '<img';
        foreach($attributes as $key => $value) {
            $tag .= ' '.$key.'="'.htmlspecialchars($value).'"';
        }
        $tag .= '>';
        return new \Twig_Markup($tag, $GLOBALS['TSFE']->renderCharset);
    }

    /**
     * @return ImageService
     */
    protected function getImageService()
    {
        /** @var ImageService $imageService */
        $imageService = $this->objectManager->get(ImageService::class);
        return $imageService;
    }
}