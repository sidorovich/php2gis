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
            //      latitude 1,      longitude 1,      latitude 2,      longitude 2, Ellipsoid,         Distance,   Init bearing, Final bearing,

            // Random tests
            [ 28.1272222222   , -15.4313888889  , 13.0961111111  , -59.6083333333  ,    $WGS84,  4864342.3823363, 259.3086909458, 242.9039707641],
            [ -6.6797222222   , -84.6725        , 42.245         , -50.8713888889  ,    $WGS84,  6411481.1151966,  29.2632076346,  40.9104059871],
            [ 45.6505555556   ,-162.4516666667  ,-74.4102777778  ,  75.5758333333  ,    $WGS84, 15772551.0118092, 201.7637398350, 285.6177618510],
            [-77.940525239306 ,-164.74985857715 , 59.859892562898, 111.54708419533 ,    $WGS84, ],
            [-45.815601738084 ,  83.45572377716 , 38.730247723279, -88.268778542182,    $WGS84, ],
            [ 74.275935378054 , 149.85266870347 , 19.049381822836, -10.439416240174,    $WGS84, ],
            [-25.375251590915 ,  78.693680436673, 45.749576648581,-104.88168230508 ,    $WGS84, ],
            [  5.4421457254524,  45.373989392712, 18.006543567407, -90.161632387974,    $WGS84, ],
            [-70.801480608434 , -66.339961814852, 31.403880883662,  94.532075223761,    $WGS84, ],
            [-11.798226470965 , -37.63351219596 ,-45.164347726463,-119.45107053008 ,    $WGS84, ],
            [ -1.1963857110573, 150.90866394849 , 39.37457803142 ,  81.83443253014 ,    $WGS84, ],
            [ 54.220306204734 , 162.9228137354  , 4.795236389523 ,  23.435782083979,    $WGS84, ],

            // Long tests

            // Short tests

            // Same points
            [28.1272222222,  -15.4313888889, 28.1272222222,  -15.4313888889,    $WGS84,       0.0      ,           null,           null],
            [28.1272222222,  -15.4313888889, 28.1272222222,  -15.4313888889,     $SK42,       0.0      ,           null,           null],
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
