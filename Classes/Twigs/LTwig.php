<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 13:02
 */

namespace LFM\Twigify\Twigs;


use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException;

class LTwig extends AbstractTwig
{
    /**
     * @param $key string
     * @param $default string
     * @param $arguments array
     * @param $extensionName string
     * @param $htmlEscape bool
     * @return string
     * @throws InvalidVariableException
     */

    public function render($key, $default=null, $arguments=null, $extensionName=null, $htmlEscape=null) {
        //key="toTop" arguments="" default="" htmlEscape="" id="" extensionName="fluid_styled_content"

        if ((string)$key === '') {
            throw new InvalidVariableException('An argument "key" or "id" has to be provided', 1351584844);
        }

        $request = $this->view->getControllerContext()->getRequest();
        $extensionName = $extensionName === null ? $request->getControllerExtensionName() : $extensionName;
        $value = static::translate($key, $extensionName, $arguments);
        if ($value === null) {
            $value = $default !== null ? $default : $key;
            if (!empty($arguments)) {
                $value = vsprintf($value, $arguments);
            }
        } elseif ($htmlEscape) {
            $value = htmlspecialchars($value);
        }
        return $value;
    }

    /**
     * Wrapper call to static LocalizationUtility
     *
     * @param string $id Translation Key compatible to TYPO3 Flow
     * @param string $extensionName UpperCamelCased extension key (for example BlogExample)
     * @param array $arguments Arguments to be replaced in the resulting string
     *
     * @return NULL|string
     */
    protected static function translate($id, $extensionName, $arguments)
    {
        return LocalizationUtility::translate($id, $extensionName, $arguments);
    }
}