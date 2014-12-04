<?php

namespace PHP2GIS\Angle\Formatter;

use PHP2GIS\Angle\AbstractAngle;
use PHP2GIS\Angle\AngleFormatterInterface;

/**
 * Class PlaneAngleFormatter
 *
 * @package PHP2GIS\Angle\Formatter
 * @since   2014-12-04
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class PlaneAngleFormatter implements AngleFormatterInterface
{
    const TEMPLATE_DDMMSS_SPACES = 1;
    const TEMPLATE_DDMMSS_SIGNS  = 2;

    protected static $TEMPLATES = [
        self::TEMPLATE_DDMMSS_SPACES => '%d %02d %02d',
        self::TEMPLATE_DDMMSS_SIGNS  => '%d°%02d′%02d″',
    ];

    /**
     * Main method for formatting angle
     *
     * @param AbstractAngle $angle
     * @param int           $format
     * @return mixed
     */
    public function formatAngle(AbstractAngle $angle, $format = self::TEMPLATE_DDMMSS_SPACES)
    {
        if (!isset(static::$TEMPLATES[$format])) {
            throw new \InvalidArgumentException('Invalid format type');
        }

        return sprintf(
            static::$TEMPLATES[$format],
            $angle->getDegrees(),
            $angle->getMinutes(),
            round($angle->getSeconds())
        );
    }
}
