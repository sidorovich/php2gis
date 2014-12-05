<?php

namespace PHP2GIS\Angle;

use PHP2GIS\Exception\InvalidArgumentException;

/**
 * Class PlaneAngle
 *
 * @package PHP2GIS\Angle
 * @since   2014-10-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class PlaneAngle extends AbstractAngle
{
    /**
     * @param float $value
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function validateFloatValue($value)
    {
        if (($value < 0) || ($value > 360)) {
            throw new InvalidArgumentException("Plane angle value must be in [0..360]");
        }
    }
}
