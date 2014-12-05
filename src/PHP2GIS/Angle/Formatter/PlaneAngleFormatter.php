<?php

namespace PHP2GIS\Angle\Formatter;

use PHP2GIS\Angle\AbstractAngle;
use PHP2GIS\Exception\InvalidArgumentException;

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
    const TEMPLATE_DDDMMSSs_DOTS = 3;

    protected static $TEMPLATES = [
        self::TEMPLATE_DDMMSS_SPACES => '%d %02d %02d',
        self::TEMPLATE_DDMMSS_SIGNS  => '%d°%02d′%02d″',
        self::TEMPLATE_DDDMMSSs_DOTS => '%03d.%02d.%s',
    ];

    protected $template;

    /**
     * @param int $template
     * @throws InvalidArgumentException
     */
    public function __construct($template = self::TEMPLATE_DDMMSS_SPACES)
    {
        if (!isset(static::$TEMPLATES[$template])) {
            throw new InvalidArgumentException('Invalid format type');
        }

        $this->template = $template;
    }

    /**
     * Main method for formatting angle
     *
     * @param AbstractAngle $angle
     * @return mixed
     */
    public function format(AbstractAngle $angle)
    {
        $seconds = $this->formatSeconds($angle);

        return sprintf(
            static::$TEMPLATES[$this->template],
            $angle->getDegrees(),
            $angle->getMinutes(),
            $seconds
        );
    }

    /**
     * @param AbstractAngle $angle
     * @return string
     */
    protected function formatSeconds(AbstractAngle $angle)
    {
        if ($this->template == static::TEMPLATE_DDDMMSSs_DOTS) {
            $seconds = number_format($angle->getSeconds(), 3);
            $seconds = (($seconds < 10) ? '0' : '') . $seconds;
        } else {
            $seconds = round($angle->getSeconds());
        }

        return $seconds;
    }
}
