<?php

use PHP2GIS\GeoPoint;
use PHP2GIS\Ellipsoid;
use PHP2GIS\Distance\DistanceVincentyCalculator;

    /**
 * Class DistanceVincentyCalculatorTest
 *
 * @package PHP2GIS
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class DistanceVincentyCalculatorTest extends \PHPUnit_Framework_TestCase
{
    const PRECISION = 1e-4;

    public function testGetDistance()
    {
        $WGS84 = Ellipsoid::ELLIPSOID_WGS84;

        $testCases = [
            //  latitude 1,     longitude 1,    latitude 2,     longitude 2, ELPS 2,    Distance,    Azimuth,
            [28.1272222222,  -15.4313888889, 13.0961111111,  -59.6083333333, $WGS84, 4880447.441, 250.062487,],
        ];

        $calculator = new DistanceVincentyCalculator();
        foreach ($testCases as $test) {
            $this->assertEquals(
                $test[5],
                $calculator->getDistance(
                    new GeoPoint($test[0], $test[1], $test[4]),
                    new GeoPoint($test[2], $test[3], $test[4])
                ),
                '',
                self::PRECISION
            );
        }
    }

    public function testGetDistanceOnDifferentEllipsoids()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $calculator = new DistanceVincentyCalculator();
        $point1 = new GeoPoint(51, 28, Ellipsoid::ELLIPSOID_WGS84);
        $point2 = new GeoPoint(28, 51, Ellipsoid::ELLIPSOID_PZ90);
        $calculator->getDistance($point1, $point2);
    }
}
