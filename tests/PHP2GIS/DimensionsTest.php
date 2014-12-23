<?php

use PHP2GIS\Dimensions;
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
            // @todo: add more test cases here
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
}
