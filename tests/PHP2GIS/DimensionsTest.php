<?php

use PHP2GIS\Dimensions;
use PHP2GIS\GeoLine;
use PHP2GIS\GeoPoint;

/**
 * Class DimensionsTest
 *
 * @since   2014-12-08
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class DimensionsTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $dimensions = new Dimensions();

        $this->assertInstanceOf('PHP2GIS\Dimensions', $dimensions);
        $this->assertNull($dimensions->getWestBorder());
        $this->assertNull($dimensions->getEastBorder());
        $this->assertNull($dimensions->getNorthBorder());
        $this->assertNull($dimensions->getWestBorder());
    }

    public function testInvalidEllipsoid()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        $dimensions = new Dimensions();
        $dimensions->expandGeoPoint(getRandomGeoPoint());
        $dimensions->expandGeoPoint(getRandomGeoPoint(\PHP2GIS\Ellipsoid::ELLIPSOID_PZ90));
    }

    public function testExpandGeoPoints()
    {
        $testCases = array(
            array(
                'result' => array(54.123456, 28.765432, 54.123456, 28.765432),
                'points' => array(
                    array(54.123456, 28.765432),
                ),
            ),
            array(
                'result' => array(54.123456, 28.765432, 56.54321, 30.123),
                'points' => array(
                    array(54.123456, 28.765432), array(56.54321, 30.123),
                ),
            ),
            array(
                'result' => array(-40, -30, 10, 20),
                'points' => array(
                    array(-20, 20), array(-40, -30), array(10, 10),
                ),
            ),
            array(
                'result' => array(-20, 160, 10, -170),
                'points' => array(
                    array(10, -170), array(-20, 170), array(10, 160),
                ),
            ),
        );

        foreach ($testCases as $test) {
            $dimensions = new Dimensions();

            foreach ($test['points'] as $point) {
                $this->assertInstanceOf('PHP2GIS\Dimensions', $dimensions->expandGeoPoint(new GeoPoint($point[0], $point[1])));
            }

            $this->assertEquals($test['result'][0], $dimensions->getSouthBorder()->getFloatValue());
            $this->assertEquals($test['result'][1], $dimensions->getWestBorder()->getFloatValue());
            $this->assertEquals($test['result'][2], $dimensions->getNorthBorder()->getFloatValue());
            $this->assertEquals($test['result'][3], $dimensions->getEastBorder()->getFloatValue());
        }
    }

    public function testExpandGeoLine()
    {
        $testCases = array(
            array(
                'result' => array(30, 30, 70, 70),
                'lines'  => array(
                    array(30, 40, 70, 60), array(40, 70, 60, 30),
                ),
            ),
            array(
                'result' => array(-30, -5, 30, 80),
                'lines'  => array(
                    array(-30, 0, 30, 60), array(-5, 80, 25, 20), array(-25, 45, 20, 60),
                    array(-10, -5, 15, -5), array(25, 5, -10, 55),
                ),
            ),
        );

        foreach ($testCases as $test) {
            $dimensions = new Dimensions();

            foreach ($test['lines'] as $line) {
                $geoLine = new GeoLine(new GeoPoint($line[0], $line[1]), new GeoPoint($line[2], $line[3]));
                $this->assertInstanceOf('PHP2GIS\Dimensions', $dimensions->expandGeoLine($geoLine));
            }

            $this->assertEquals($test['result'][0], $dimensions->getSouthBorder()->getFloatValue());
            $this->assertEquals($test['result'][1], $dimensions->getWestBorder()->getFloatValue());
            $this->assertEquals($test['result'][2], $dimensions->getNorthBorder()->getFloatValue());
            $this->assertEquals($test['result'][3], $dimensions->getEastBorder()->getFloatValue());
        }
    }
}
