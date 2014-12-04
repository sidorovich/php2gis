<?php

namespace PHP2GIS\Angle\Formatter;

/**
 * Class LongitudeFormatter
 *
 * @package PHP2GIS\Angle\Formatter
 * @since   2014-12-04
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class LongitudeFormatter extends LatitudeFormatter
{
    protected static $SYMBOLS = ['E', 'W'];

    protected static $TEMPLATES = [
        self::TEMPLATE_DDMMSS_SPACES => '%03d %02d %02d',
        self::TEMPLATE_DDMMSS_SIGNS  => '%03d°%02d′%02d″',
    ];
}
