<?php
/**
 * Created by PhpStorm.
 * User: Lars_Soendergaard
 * Date: 19.02.2016
 * Time: 12:54
 */

namespace LFM\Twigify\Twigs;


class DateFormatTwig extends AbstractTwig
{
    public function render($date, $format) {
        if (is_numeric($date)) {
            $tmp = new \DateTime();
            $tmp->setTimestamp($date);
            $date = $tmp;
        } elseif (is_string($date)) {
            $date = new \DateTime($date);
        }
        if (strpos($format, '%') !== false) {
            return strftime($format, $date->format('U'));
        } else {
            return $date->format($format);
        }
    }
}
