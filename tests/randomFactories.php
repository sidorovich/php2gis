<?php

/**
 * Factories for generate random data
 *
 * @since   2014-12-06
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */

use PHP2GIS\Ellipsoid;
use PHP2GIS\GeoPoint;
use PHP2GIS\GeoLine;

/**
 * Generate random Geo Point
 *
 * @param string $ellipsoid
 * @return GeoPoint
 */
function getRandomGeoPoint($ellipsoid = Ellipsoid::ELLIPSOID_WGS84)
{
    return new GeoPoint(rand(-90, 90), rand(-180, 180), $ellipsoid);
}

/**
 * Generate random geo line for tests
 *
 * @param string $ellipsoid
 * @return GeoLine
 */
function getRandomGeoLine($ellipsoid = Ellipsoid::ELLIPSOID_WGS84)
{
    return new GeoLine(getRandomGeoPoint($ellipsoid), getRandomGeoPoint($ellipsoid));
}
