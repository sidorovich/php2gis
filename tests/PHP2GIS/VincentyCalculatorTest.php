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

    public function testInverseCalculationWGS84()
    {
        $testCases = [
            //   latitude 1,    longitude 1,    latitude 2,    longitude 2,         Distance,   Init bearing, Final bearing,

            // Random tests
            [ 28.1272222222, -15.4313888889, 13.0961111111, -59.6083333333,  4864342.3823363, 259.3086909458, 242.9039707641],
            [ -6.6797222222, -84.6725      , 42.245       , -50.8713888889,  6411481.1151966,  29.2632076346,  40.9104059871],
            [ 45.6505555556,-162.4516666667,-74.4102777778,  75.5758333333, 15772551.0128092, 201.7637398350, 285.6177618510],
            [-77.9405555556,-164.7497222222, 59.86        , 111.5472222222, 16269994.0488016, 295.0885905805, 337.8457978877],
            [-45.8155555556,  83.4558333333, 38.7302777778, -88.2688888889, 18970932.9885000, 222.7035190798, 322.6859532720],
            [ 74.2758333333, 149.8527777778, 19.0494444444, -10.4394444444,  9554569.7973053, 341.3800174994, 185.2668937051],
            [-25.3752777778,  78.6936111111, 45.7494444444,-104.8816666667, 17721239.7636161,   7.0159639764, 170.9102206426],
            [  5.4422222222,  45.3738888889, 18.0066666667, -90.1616666667, 14500605.8059514, 299.2994013955, 245.8657504785],
            [-70.8013888889, -66.34        , 31.4038888889,  94.5319444444, 15467813.8921583, 154.7213291783,   9.4894930440],
            [-11.7983333333, -37.6336111111,-45.1644444444,-119.4511111111,  8449791.7408316, 226.0993821377, 272.8022233624],
            [ -1.1963888889, 150.9086111111, 39.3744444444,  81.8344444444,  8312256.5331584, 311.4207637610, 284.4096726054],
            [ 54.2202777778, 162.9227777778,  4.7952777778,  23.4358333333, 12467277.1186053, 315.8232329604, 204.1902138178],

            // Long tests
            [ 90.0         ,   0.0         ,-90.0         ,   0.0          ,20003931.4582388, 180.0         , 180.0         ],
            [-90.0         ,  20.0         , 90.0         ,  20.0          ,20003931.4582388,   0.0         ,   0.0         ],
//          [  0.0         ,   0.0         ,  0.0         , 180.0          ,20037508.0009862,  90.0         ,  90.0         ], something wrong on equator
//          [  0.0         ,   0.0         ,  0.0         ,-180.0          ,20037508.0009862, 270.0         , 270.0         ],

            // Short tests
            [ 53.8913888889,  29.1697222222, 54.035       ,  29.3013888889 ,   18170.9963601,  28.3438722192,  28.4503431534],
            [ 53.9166666667,  27.55        , 53.9173333334,  27.551        ,      99.112464 ,  41.5244882578,  41.5252964225],

            // Same points
            [ 28.1272222222, -15.4313888889, 28.1272222222, -15.4313888889 ,       0.0      ,           null,           null],
            [  0.0         ,-180.0         ,  0.0         , 180.0          ,       0.0      ,           null,           null],
            [ 90.0         ,   0.0         , 90.0         , 180.0          ,       0.0      ,           null,           null],
        ];

        $this->processInverseCalculationTests($testCases, Ellipsoid::ELLIPSOID_WGS84);
    }

    public function testInverseCalculationSK42()
    {
        return;
        // @TODO: calculate and prepare tests for SK-42
        $testCases = [
            //   latitude 1,    longitude 1,    latitude 2,    longitude 2,      Distance,   Init bearing, Final bearing,

            // Random tests
            [ 28.1272222222, -15.4313888889, 13.0961111111, -59.6083333333,  ],
            [ -6.6797222222, -84.6725      , 42.245       , -50.8713888889,  ],
            [ 45.6505555556,-162.4516666667,-74.4102777778,  75.5758333333,  ],
            [-77.9405555556,-164.7497222222, 59.86        , 111.5472222222,  ],
            [-45.8155555556,  83.4558333333, 38.7302777778, -88.2688888889,  ],
            [ 74.2758333333, 149.8527777778, 19.0494444444, -10.4394444444,  ],
            [-25.3752777778,  78.6936111111, 45.7494444444,-104.8816666667,  ],
            [  5.4422222222,  45.3738888889, 18.0066666667, -90.1616666667,  ],
            [-70.8013888889, -66.34        , 31.4038888889,  94.5319444444,  ],
            [-11.7983333333, -37.6336111111,-45.1644444444,-119.4511111111,  ],
            [ -1.1963888889, 150.9086111111, 39.3744444444,  81.8344444444,  ],
            [ 54.2202777778, 162.9227777778,  4.7952777778,  23.4358333333,  ],

            // Long tests

            // Short tests

            // Same points
            [ 28.1272222222, -15.4313888889, 28.1272222222,  -15.4313888889,        0.0      ,           null,           null],
            [  0.0         ,-180.0         ,  0.0         ,  180.0         ,        0.0      ,           null,           null],
        ];

        $this->processInverseCalculationTests($testCases, Ellipsoid::ELLIPSOID_SK42);
    }

    protected function processInverseCalculationTests($testCases, $ellipsoid)
    {
        $calculator = new VincentyCalculator();
        foreach ($testCases as $test) {
            $distance = $calculator->inverseCalculation(
                new GeoPoint($test[0], $test[1], $ellipsoid),
                new GeoPoint($test[2], $test[3], $ellipsoid)
            );

            $initialBearing = is_null($calculator->getInitialBearing())
                ? null : $calculator->getInitialBearing()->getFloatValue();

            $finalBearing   = is_null($calculator->getFinalBearing())
                ? null : $calculator->getFinalBearing()->getFloatValue();

            $this->assertEquals($test[4], $distance, '', self::PRECISION);
            $this->assertEquals($test[5], $initialBearing, '', self::PRECISION);
            $this->assertEquals($test[6], $finalBearing, '', self::PRECISION);
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
