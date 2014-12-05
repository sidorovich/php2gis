<?php

namespace PHP2GIS\Angle;

use PHP2GIS\Exception\InvalidArgumentException;

/**
 * Class Longitude
 *
 * @package PHP2GIS\Angle
 * @since   2014-10-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class Longitude extends AbstractAngle
{
    /**
     * @param float $value
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function validateFloatValue($value)
    {
        if (($value < -180.0) || ($value > 180.0)) {
            throw new InvalidArgumentException("Longitude value must be in [-180..180]");
        }
    }
}
