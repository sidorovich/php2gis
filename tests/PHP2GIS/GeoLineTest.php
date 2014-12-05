<?php

use PHP2GIS\Ellipsoid;
use PHP2GIS\GeoLine;
use PHP2GIS\GeoPoint;

/**
 * Class GeoLineTest
 *
 * @package PHP2GIS
 * @since   2014-12-05
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class GeoLineTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $point1 = new GeoPoint(rand(-90, 90), rand(-180, 180));
        $point2 = new GeoPoint(rand(-90, 90), rand(-180, 180));

        $line = new GeoLine($point1, $point2);

        $this->assertInstanceOf('PHP2GIS\GeoLine', $line);
        $this->assertEquals($point1, $line->getStart());
        $this->assertEquals($point2, $line->getEnd());
    }

    public function testDifferentEllipsoidsInConstructor()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        new GeoLine(
            new GeoPoint(rand(-90, 90), rand(-180, 180)),
            new GeoPoint(rand(-90, 90), rand(-180, 180), Ellipsoid::ELLIPSOID_PZ90)
        );
    }

    public function testDifferentEllipsoidsInSetStart()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        $point1 = new GeoPoint(rand(-90, 90), rand(-180, 180));
        $point2 = new GeoPoint(rand(-90, 90), rand(-180, 180));

        $line = new GeoLine($point1, $point2);
        $line->setStart(new GeoPoint(rand(-90, 90), rand(-180, 180), Ellipsoid::ELLIPSOID_PZ90));
    }

    public function testDifferentEllipsoidsInSetEnd()
    {
        $this->setExpectedException('PHP2GIS\Exception\MismatchEllipsoidException');
        $point1 = new GeoPoint(rand(-90, 90), rand(-180, 180));
        $point2 = new GeoPoint(rand(-90, 90), rand(-180, 180));

        $line = new GeoLine($point1, $point2);
        $line->setEnd(new GeoPoint(rand(-90, 90), rand(-180, 180), Ellipsoid::ELLIPSOID_PZ90));
    }
}
