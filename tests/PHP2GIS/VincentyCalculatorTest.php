<?php

use PHP2GIS\GeoPoint;
use PHP2GIS\Ellipsoid;
use PHP2GIS\VincentyCalculator;

/**
 * Class DistanceVincentyCalculatorTest
 *
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class VincentyCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInverseCalculationWGS84()
    {
        $testCases = array(
            //        latitude 1,    longitude 1,    latitude 2,    longitude 2,         Distance,   Init bearing,   Final bearing,

            // Random tests
            array( 28.1272222222, -15.4313888889, 13.0961111111, -59.6083333333,  4864342.3823363, 259.3086909458, 242.9039707641),
            array( -6.6797222222, -84.6725      , 42.245       , -50.8713888889,  6411481.1151966,  29.2632076346,  40.9104059871),
            array( 45.6505555556,-162.4516666667,-74.4102777778,  75.5758333333, 15772551.0128092, 201.7637398350, 285.6177618510),
            array(-77.9405555556,-164.7497222222, 59.86        , 111.5472222222, 16269994.0488016, 295.0885905805, 337.8457978877),
            array(-45.8155555556,  83.4558333333, 38.7302777778, -88.2688888889, 18970932.9885000, 222.7035190798, 322.6859532720),
            array( 74.2758333333, 149.8527777778, 19.0494444444, -10.4394444444,  9554569.7973053, 341.3800174994, 185.2668937051),
            array(-25.3752777778,  78.6936111111, 45.7494444444,-104.8816666667, 17721239.7636161,   7.0159639764, 170.9102206426),
            array(  5.4422222222,  45.3738888889, 18.0066666667, -90.1616666667, 14500605.8059514, 299.2994013955, 245.8657504785),
            array(-70.8013888889, -66.34        , 31.4038888889,  94.5319444444, 15467813.8921583, 154.7213291783,   9.4894930440),
            array(-11.7983333333, -37.6336111111,-45.1644444444,-119.4511111111,  8449791.7408316, 226.0993821377, 272.8022233624),
            array( -1.1963888889, 150.9086111111, 39.3744444444,  81.8344444444,  8312256.5331584, 311.4207637610, 284.4096726054),
            array( 54.2202777778, 162.9227777778,  4.7952777778,  23.4358333333, 12467277.1186053, 315.8232329604, 204.1902138178),

            // Long tests
            array( 90.0         ,   0.0         ,-90.0         ,   0.0          ,20003931.4582388, 180.0         , 180.0         ),
            array(-90.0         ,  20.0         , 90.0         ,  20.0          ,20003931.4582388,   0.0         ,   0.0         ),
//          array(  0.0         ,   0.0         ,  0.0         , 180.0          ,20037508.0009862,  90.0         ,  90.0         ), something wrong on equator
//          array(  0.0         ,   0.0         ,  0.0         ,-180.0          ,20037508.0009862, 270.0         , 270.0         ),

            // Short tests
            array( 53.8913888889,  29.1697222222, 54.035       ,  29.3013888889 ,   18170.9963601,  28.3438722192,  28.4503431534),
            array( 53.9166666667,  27.55        , 53.9173333334,  27.551        ,      99.112464 ,  41.5244882578,  41.5252964225),

            // Same points
            array( 28.1272222222, -15.4313888889, 28.1272222222, -15.4313888889 ,       0.0      ,           null,           null),
            array(  0.0         ,-180.0         ,  0.0         , 180.0          ,       0.0      ,           null,           null),
            array( 90.0         ,   0.0         , 90.0         , 180.0          ,       0.0      ,           null,           null),
        );

        $this->processInverseCalculationTests($testCases, Ellipsoid::ELLIPSOID_WGS84);
    }

    public function testInverseCalculationSK42()
    {
        $testCases = array(
            //        latitude 1,    longitude 1,    latitude 2,    longitude 2,          Distance,   Init bearing,  Final bearing,

            // Random tests
            array( 28.1272222222, -15.4313888889, 13.0961111111, -59.6083333333,  4864424.93338999, 259.3086752724, 242.903955792),
            array( -6.6797222222, -84.6725      , 42.245       , -50.8713888889,  6411593.05379899,  29.2631870437,  40.910384608),
            array( 45.6505555556,-162.4516666667,-74.4102777778,  75.5758333333, 15772823.443595  , 201.7637372581, 285.617743641),
            array(-77.9405555556,-164.7497222222, 59.86        , 111.5472222222, 16270275.57779   , 295.0886023488, 337.845802489),
            array(-45.8155555556,  83.4558333333, 38.7302777778, -88.2688888889, 18971257.858084  , 222.7036603409, 322.685839194),
            array( 74.2758333333, 149.8527777778, 19.0494444444, -10.4394444444,  9554731.310913  , 341.3800147287, 185.266892373),
            array(-25.3752777778,  78.6936111111, 45.7494444444,-104.8816666667, 17721543.538343  ,   7.0159776468, 170.910201417),
            array(  5.4422222222,  45.3738888889, 18.0066666667, -90.1616666667, 14500851.439827  , 299.2993851067, 245.865776189),
            array(-70.8013888889, -66.34        , 31.4038888889,  94.5319444444, 15468080.173499  , 154.7213182006,   9.48949406 ),
            array(-11.7983333333, -37.6336111111,-45.1644444444,-119.4511111111,  8449935.09294   , 226.0993698208, 272.80220594 ),
            array( -1.1963888889, 150.9086111111, 39.3744444444,  81.8344444444,  8312398.785554  , 311.4207828709, 284.409695147),
            array( 54.2202777778, 162.9227777778,  4.7952777778,  23.4358333333, 12467488.806863  , 315.8232160923, 204.190213548),

            // Long tests

            // Short tests

            // Same points
            array( 28.1272222222, -15.4313888889, 28.1272222222,  -15.4313888889,        0.0      ,           null,           null),
            array(  0.0         ,-180.0         ,  0.0         ,  180.0         ,        0.0      ,           null,           null),
        );

        $this->processInverseCalculationTests($testCases, Ellipsoid::ELLIPSOID_SK42);
    }

    public function testInverseCalculationOnDifferentEllipsoids()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        $calculator = new VincentyCalculator();
        $point1 = new GeoPoint(51, 28, Ellipsoid::ELLIPSOID_WGS84);
        $point2 = new GeoPoint(28, 51, Ellipsoid::ELLIPSOID_PZ90);
        $calculator->inverseCalculation($point1, $point2);
    }

    public function testDirectCalculationWGS84()
    {
        $testCases = array(
            // Random tests
            //          Latitude,      Longitude,Distance (meters),Initial bearing,   Result  Lat,    Result Long, Final bearing
            array( 28.1272222222, -15.4313888889,  4864342.3823363, 259.3086909458, 13.0961111111, -59.6083333333, 242.90397076,),
            array(-25.3752777778,  78.6936111111, 17721239.7636161,   7.0159639764, 45.7494444444,-104.8816666667, 170.91022064,),
            array( 65.0479465514, 144.0172799137,  2040319.2487804, 118.0136305457, 52.9881037103, 171.4189924582, 141.75226913,),
            array( 84.6976571692, -15.4751404540, 19601718.199314 ,  73.1517156740,-82.7822487703, 135.9061243285, 135.25389944,),
            array(-51.7472103339, -84.0584828630, 14663016.185919 , 304.5562190304, 51.9636896006, 178.2328634619, 304.15400822,),
            array( 15.2207062325, 136.1129137111,  6934395.6425482, 150.1466497919,-38.5138967098, 170.3076491627, 142.17833078,),
            array(-56.9770517140, 174.2056169893,  8902690.5910534, 288.9162989934,  1.8030217731, 105.5103660916, 328.86781730,),
            array( 53.1511030081,-126.7122396579,  2626968.7377682,  91.8739324118, 46.5115302773, -91.2323659139, 119.39341838,),
            array(-52.2799908380, 158.6081633617,  3537676.7817084, 231.4020664019,-60.8865541656, 101.0412136872, 280.79562358,),
            array( -6.9204491642,   1.6490195047,  2999279.0710997,  25.8068730430, 17.4657046222,  13.5771356323,  26.93247213,),

            // Long tests
            array( 90.0         ,   0.0         , 20003931.4582388, 180.0         , -90.0        ,   0.0         , 180.0       ,),
            array( 90.0         ,   0.0         , 40007862.9164776, 180.0         ,  90.0        ,-180.0         ,   0.0       ,),
            // Short tests
        );

        $this->processDirectCalculationTests($testCases, Ellipsoid::ELLIPSOID_WGS84);
    }

    public function testDirectCalculationSK42()
    {

    }

    protected function processDirectCalculationTests($testCases, $ellipsoid)
    {
        $calculator = new VincentyCalculator();
        foreach ($testCases as $test) {
            $point = new GeoPoint($test[0], $test[1], $ellipsoid);

            $end1 = $calculator->directCalculation($point, new \PHP2GIS\Angle\PlaneAngle($test[3]), $test[2]);
            $this->assertInstanceOf('PHP2GIS\GeoPoint', $end1);
            $this->assertEquals($ellipsoid, $end1->getEllipsoid()->getName());
            $this->assertEquals($test[4], $end1->getLatitude()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[5], $end1->getLongitude()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[6], $calculator->getFinalBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);

            $end2 = $calculator->directCalculation($point, $test[3], $test[2]);
            $this->assertInstanceOf('PHP2GIS\GeoPoint', $end2);
            $this->assertEquals($ellipsoid, $end2->getEllipsoid()->getName());
            $this->assertEquals($test[4], $end2->getLatitude()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[5], $end2->getLongitude()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[6], $calculator->getFinalBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);

            $end3 = $calculator->directCalculation($point, deg2rad($test[3]), $test[2], true);
            $this->assertInstanceOf('PHP2GIS\GeoPoint', $end3);
            $this->assertEquals($ellipsoid, $end3->getEllipsoid()->getName());
            $this->assertEquals($test[4], $end3->getLatitude()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[5], $end3->getLongitude()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[6], $calculator->getFinalBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);

            $this->assertTrue($end1->isEqual($end2));
            $this->assertTrue($end2->isEqual($end3));
        }
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

            $this->assertEquals($test[4], $distance, '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[5], $initialBearing, '', ASSERT_FLOAT_PRECISION);
            $this->assertEquals($test[6], $finalBearing, '', ASSERT_FLOAT_PRECISION);
        }
    }
}
