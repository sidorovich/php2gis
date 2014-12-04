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
    const PRECISION = 1e-3;

    public function testInverseCalculation()
    {
        $WGS84 = Ellipsoid::ELLIPSOID_WGS84;
        $SK42  = Ellipsoid::ELLIPSOID_SK42;

        $testCases = [
            //   latitude 1,    longitude 1,    latitude 2,    longitude 2, Ellipsoid,         Distance,   Init bearing, Final bearing,

            // Random tests
            [ 28.1272222222, -15.4313888889, 13.0961111111, -59.6083333333,    $WGS84,  4864342.3823363, 259.3086909458, 242.9039707641],
            [ -6.6797222222, -84.6725      , 42.245       , -50.8713888889,    $WGS84,  6411481.1151966,  29.2632076346,  40.9104059871],
            [ 45.6505555556,-162.4516666667,-74.4102777778,  75.5758333333,    $WGS84, 15772551.0128092, 201.7637398350, 285.6177618510],
            [-77.9405555556,-164.7497222222, 59.86        , 111.5472222222,    $WGS84, 16269994.0488016, 295.0885905805, 337.8457978877],
            [-45.8155555556,  83.4558333333, 38.7302777778, -88.2688888889,    $WGS84, 18970932.9885000, 222.7035190798, 322.6859532720],
            [ 74.2758333333, 149.8527777778, 19.0494444444, -10.4394444444,    $WGS84,  9554569.7973053, 341.3800174994, 185.2668937051],
            [-25.3752777778,  78.6936111111, 45.7494444444,-104.8816666667,    $WGS84, 17721239.7636161,   7.0159639764, 170.9102206426],
            [  5.4422222222,  45.3738888889, 18.0066666667, -90.1616666667,    $WGS84, 14500605.8059514, 299.2994013955, 245.8657504785],
            [-70.8013888889, -66.34        , 31.4038888889,  94.5319444444,    $WGS84, 15467813.8921583, 154.7213291783,   9.4894930440],
            [-11.7983333333, -37.6336111111,-45.1644444444,-119.4511111111,    $WGS84,  8449791.7408316, 226.0993821377, 272.8022233624],
            [ -1.1963888889, 150.9086111111, 39.3744444444,  81.8344444444,    $WGS84,  8312256.5331584, 311.4207637610, 284.4096726054],
            [ 54.2202777778, 162.9227777778,  4.7952777778,  23.4358333333,    $WGS84, 12467277.1186053, 315.8232329604, 204.1902138178],

            // Long tests

            // Short tests

            // Same points
            [ 28.1272222222, -15.4313888889, 28.1272222222,  -15.4313888889,    $WGS84,       0.0      ,           null,           null],
            [ 28.1272222222, -15.4313888889, 28.1272222222,  -15.4313888889,     $SK42,       0.0      ,           null,           null],
            [  0.0         ,-180.0         ,  0.0         ,  180.0         ,    $WGS84,       0.0      ,           null,           null],
            [  0.0         ,-180.0         ,  0.0         ,  180.0         ,     $SK42,       0.0      ,           null,           null],
        ];

        $calculator = new VincentyCalculator();
        foreach ($testCases as $test) {
            $distance = $calculator->inverseCalculation(
                new GeoPoint($test[0], $test[1], $test[4]),
                new GeoPoint($test[2], $test[3], $test[4])
            );

            $initialBearing = is_null($calculator->getInitialBearing())
                ? null : $calculator->getInitialBearing()->getFloatValue();

            $finalBearing   = is_null($calculator->getFinalBearing())
                ? null : $calculator->getFinalBearing()->getFloatValue();

            $this->assertEquals($test[5], $distance, '', self::PRECISION);
            $this->assertEquals($test[6], $initialBearing, '', self::PRECISION);
            $this->assertEquals($test[7], $finalBearing, '', self::PRECISION);
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
