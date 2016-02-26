<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 25.02.2016
 * Time: 16:54
 */

namespace LFM\Twigify\DataProcessing;

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentDataProcessor;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;

class FlexFormProcessor implements DataProcessorInterface
{
    /**
     * @var ContentObjectRenderer
     */
    protected $cObj;

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $this->cObj = $cObj;
        $fieldName = isset($processorConfiguration['fieldName']) ? $processorConfiguration['fieldName'] : 'pi_flexform';
        $as = isset($processorConfiguration['as']) ? $processorConfiguration['as'] : 'flexData';
        $data = $processedData['data'];

        //$tcaConfig = $GLOBALS['TCA']['tt_content']['columns'][$fieldName]['config'];
        //$ds = BackendUtility::getFlexFormDS($tcaConfig, $data, 'tt_content', $fieldName);

        $flexArray['sheets'] = GeneralUtility::xml2array($data[$fieldName], 'T3')['data'];
        $sheetData = $this->getSheets($flexArray);
        $processedData[$as] = $sheetData;
        return $processedData;
    }


    public function getSheets($flexArray) {

        $sheets = [];
        foreach($flexArray['sheets'] as $key => $sheet) {
            $sheet = ['sDEF' => $sheet];
            $data = [];
            $this->cObj->readFlexformIntoConf(['data' => $sheet], $data, 'T3');
            $sheets[$key] = $data;
        }

        if(count($sheets) > 1) {
            return $sheets;
        }
        return array_pop($sheets);
    }

}