<?php

namespace PHP2GIS\Angle\Formatter;

use PHP2GIS\Angle\AbstractAngle;

/**
 * Class LatitudeFormatter
 *
 * @package PHP2GIS\Angle\Formatter
 * @since   2014-12-04
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class LatitudeFormatter extends PlaneAngleFormatter
{
    const SYMBOL_LEADING = 1;
    const SYMBOL_ENDING  = 2;

    protected static $SYMBOLS = ['N', 'S'];

    protected static $TEMPLATES = [
        self::TEMPLATE_DDMMSS_SPACES => '%02d %02d %02d',
        self::TEMPLATE_DDMMSS_SIGNS  => '%02d°%02d′%02d″',
    ];


    /**
     * Main method for formatting angle
     *
     * @param AbstractAngle $angle
     * @param int           $format
     * @param int           $symbolPosition
     * @return mixed
     */
    public function formatAngle(AbstractAngle $angle, $format = self::TEMPLATE_DDMMSS_SPACES, $symbolPosition = self::SYMBOL_LEADING)
    {
        $angleCloned = clone $angle;
        $string = parent::formatAngle($angleCloned->setDegrees(abs($angleCloned->getDegrees())), $format);

        $symbol = ($angle->getFloatValue() >= 0) ? static::$SYMBOLS[0] : static::$SYMBOLS[1];

        if ($symbolPosition == self::SYMBOL_ENDING) {
            return $string . $symbol;
        } else {
            return $symbol . $string;
        }
    }
}
