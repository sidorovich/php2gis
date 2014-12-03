<?php

namespace PHP2GIS\Distance;

use PHP2GIS\GeoPoint;

/**
 * Interface DistanceCalculatorInterface
 *
 * @package PHP2GIS\Distance
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
interface DistanceCalculatorInterface
{

    /**
     * Calculate distance in meters between two points
     *
     * @param GeoPoint $point1
     * @param GeoPoint $point2
     * @return float // meters
     */
    public function getDistance(GeoPoint $point1, GeoPoint $point2);
}
