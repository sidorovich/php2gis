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

    protected static $SYMBOLS = array('N', 'S');

    protected static $TEMPLATES = array(
        self::TEMPLATE_DDMMSS_SPACES => '%02d %02d %02d',
        self::TEMPLATE_DDMMSS_SIGNS  => '%02d°%02d′%02d″',
        self::TEMPLATE_DDDMMSSs_DOTS => '%03d.%02d.%s',
    );

    protected $symbolPosition;

    /**
     * @param int $template
     * @param int $symbolPosition
     */
    public function __construct($template = self::TEMPLATE_DDMMSS_SPACES, $symbolPosition = self::SYMBOL_LEADING)
    {
        parent::__construct($template);
        $this->symbolPosition = $symbolPosition;
    }

    /**
     * Main method for formatting Latitude
     *
     * @param AbstractAngle $angle
     * @return mixed
     */
    public function format(AbstractAngle $angle)
    {
        $angleCloned = clone $angle;
        $string = parent::format($angleCloned->setDegrees(abs($angleCloned->getDegrees())), $this->template);

        $symbol = ($angle->getFloatValue() >= 0) ? static::$SYMBOLS[0] : static::$SYMBOLS[1];

        if ($this->symbolPosition == self::SYMBOL_ENDING) {
            return $string . $symbol;
        } else {
            return $symbol . $string;
        }
    }
}
