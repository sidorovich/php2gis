<?php

namespace PHP2GIS\Angle;

/**
 * Class Latitude
 *
 * @package PHP2GIS\Angle
 * @since   2014-10-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class Latitude extends AbstractAngle
{
    /**
     * @param float $value
     * @return $this
     * @throws \InvalidArgumentException
     */
    protected function validateFloatValue($value)
    {
        if (($value < -90.0) || ($value > 90.0)) {
            throw new \InvalidArgumentException("Latitude value must be in [-90..90]");
        }
    }
}
