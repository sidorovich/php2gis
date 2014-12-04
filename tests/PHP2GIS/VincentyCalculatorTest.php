<?php

use PHP2GIS\GeoPoint;
use PHP2GIS\Ellipsoid;
use PHP2GIS\VincentyCalculator;

    /**
 * Class DistanceVincentyCalculatorTest
 *
 * @package PHP2GIS
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class VincentyCalculatorTest extends \PHPUnit_Framework_TestCase
{
    const PRECISION = 1e-4;

    public function testInverseCalculation()
    {
        $WGS84 = Ellipsoid::ELLIPSOID_WGS84;

        $testCases = [
            //  latitude 1,     longitude 1,    latitude 2,     longitude 2, Ellipsoid,        Distance,   Init bearing, Final bearing,
            [28.1272222222,  -15.4313888889, 13.0961111111,  -59.6083333333,    $WGS84, 4864342.3823363, 259.3086909458, 242.9039707641],
        ];

        $calculator = new VincentyCalculator();
        foreach ($testCases as $test) {
            $distance = $calculator->inverseCalculation(
                new GeoPoint($test[0], $test[1], $test[4]),
                new GeoPoint($test[2], $test[3], $test[4])
            );

            $this->assertEquals($test[5], $distance, '', self::PRECISION);
            $this->assertEquals($test[6], $calculator->getInitialBearing()->getFloatValue(), '', self::PRECISION);
            $this->assertEquals($test[7], $calculator->getFinalBearing()->getFloatValue(), '', self::PRECISION);
        }
    }

    public function testInverseCalculationOnDifferentEllipsoids()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $calculator = new VincentyCalculator();
        $point1 = new GeoPoint(51, 28, Ellipsoid::ELLIPSOID_WGS84);
        $point2 = new GeoPoint(28, 51, Ellipsoid::ELLIPSOID_PZ90);
        $calculator->inverseCalculation($point1, $point2);
    }
}
