<?php

use PHP2GIS\Ellipsoid;
use PHP2GIS\GeoLine;
use PHP2GIS\GeoPoint;

/**
 * Class GeoLineTest
 *
 * @since   2014-12-05
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class GeoLineTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $point1 = getRandomGeoPoint();
        $point2 = getRandomGeoPoint();

        $line = new GeoLine($point1, $point2);

        $this->assertInstanceOf('PHP2GIS\GeoLine', $line);
        $this->assertEquals($point1, $line->getStart());
        $this->assertEquals($point2, $line->getEnd());
    }

    public function testDifferentEllipsoidsInConstructor()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        new GeoLine(
            getRandomGeoPoint(),
            getRandomGeoPoint(Ellipsoid::ELLIPSOID_PZ90)
        );
    }

    public function testDifferentEllipsoidsInSetStart()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        $line = getRandomGeoLine();
        $line->setStart(getRandomGeoPoint(Ellipsoid::ELLIPSOID_PZ90));
    }

    public function testDifferentEllipsoidsInSetEnd()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        $line = getRandomGeoLine();
        $line->setEnd(getRandomGeoPoint(Ellipsoid::ELLIPSOID_PZ90));
    }

    public function testSettersGetters()
    {
        $line = getRandomGeoLine();
        $point = getRandomGeoPoint();

        $this->assertInstanceOf('PHP2GIS\GeoLine', $line->setStart($point));
        $this->assertEquals($point, $line->getStart());

        $point = getRandomGeoPoint();

        $this->assertInstanceOf('PHP2GIS\GeoLine', $line->setEnd($point));
        $this->assertEquals($point, $line->getEnd());
    }

    public function testGetDistance()
    {
        $line = $this->getGeoLine();
        $this->assertFalse($line->isCalc());
        $this->assertEquals(18170.9963601, $line->getDistance(), '', ASSERT_FLOAT_PRECISION);
        $this->assertTrue($line->isCalc());
        $this->assertEquals(28.3438722192, $line->getInitialBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
        $this->assertEquals(28.4503431534, $line->getFinalBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
    }

    public function testGetInitialBearing()
    {
        $line = $this->getGeoLine();
        $this->assertFalse($line->isCalc());
        $this->assertEquals(28.3438722192, $line->getInitialBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
        $this->assertTrue($line->isCalc());
        $this->assertEquals(18170.9963601, $line->getDistance(), '', ASSERT_FLOAT_PRECISION);
        $this->assertEquals(28.4503431534, $line->getFinalBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
    }

    public function testGetFinalBearing()
    {
        $line = $this->getGeoLine();
        $this->assertFalse($line->isCalc());
        $this->assertEquals(28.4503431534, $line->getFinalBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
        $this->assertTrue($line->isCalc());
        $this->assertEquals(18170.9963601, $line->getDistance(), '', ASSERT_FLOAT_PRECISION);
        $this->assertEquals(28.3438722192, $line->getInitialBearing()->getFloatValue(), '', ASSERT_FLOAT_PRECISION);
    }

    public function testParametersOnSamePoints()
    {
        $point = getRandomGeoPoint();
        $line = new StubGeoLine($point, $point);
        $this->assertFalse($line->isCalc());
        $this->assertEquals(0.0, $line->getDistance());
        $this->assertTrue($line->isCalc());
        $this->assertNull($line->getInitialBearing());
        $this->assertNull($line->getFinalBearing());
    }

    public function testGeoJSON()
    {
        $line = new GeoLine(new GeoPoint(12.345678, -123.456789), new GeoPoint(-87.654321, 111.111111));

        $this->assertEquals(
            '{"type":"LineString","coordinates":[[12.345678,-123.456789],[-87.654321,111.111111]]}',
            json_encode($line->toGeoJson())
        );
    }

    protected function getGeoLine()
    {
        return new StubGeoLine(new GeoPoint(53.8913888889, 29.1697222222), new GeoPoint(54.035, 29.3013888889));
    }
}

class StubGeoLine extends GeoLine
{
    public function isCalc()
    {
        return $this->isCalculated;
    }
}
