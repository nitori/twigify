<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 13:02
 */

namespace LFM\Twigify\Twigs;

class PageInfoTwig extends AbstractTwig
{
    /**
     * @param $pageUid integer
     */
    public function render($pageUid) {
        /** @var \TYPO3\CMS\Core\Database\DatabaseConnection $db */
        $db = $GLOBALS['TYPO3_DB'];
        return $db->exec_SELECTgetSingleRow('*', 'pages', implode(' AND ', [
            'uid='.intval($pageUid),
            'NOT deleted',
        ]));
    }
}