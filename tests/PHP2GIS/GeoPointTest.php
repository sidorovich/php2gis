<?php

use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Longitude;
use PHP2GIS\Ellipsoid;
use PHP2GIS\GeoPoint;

/**
 * Class GeoPointTest
 *
 * @package PHP2GIS
 * @since   2014-12-02
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class GeoPointTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $point = new GeoPoint(54, 28);

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point);
        $this->assertEquals(54, $point->getLatitude()->getFloatValue(), $point->getLongitude()->getFloatValue());
    }

    public function testLatitude()
    {
        $point = new GeoPoint(new Latitude(54), 28);

        $this->assertInstanceOf('PHP2GIS\Angle\Latitude', $point->getLatitude());
        $this->assertEquals(54.0, $point->getLatitude()->getFloatValue());

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point->setLatitude(36));
        $this->assertEquals(36.0, $point->getLatitude()->getFloatValue());

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point->setLatitude(new Latitude(-58)));
        $this->assertEquals(-58.0, $point->getLatitude()->getFloatValue());
    }

    public function testLongitude()
    {
        $point = new GeoPoint(54, new Longitude(28));

        $this->assertInstanceOf('PHP2GIS\Angle\Longitude', $point->getLongitude());
        $this->assertEquals(28.0, $point->getLongitude()->getFloatValue());

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point->setLongitude(33.5));
        $this->assertEquals(33.5, $point->getLongitude()->getFloatValue());

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point->setLongitude(new Longitude(-25.25)));
        $this->assertEquals(-25.25, $point->getLongitude()->getFloatValue());
    }

    public function testEllipsoid()
    {
        $point = new GeoPoint(54, new Longitude(28));

        $this->assertEquals(Ellipsoid::create(), $point->getEllipsoid());

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point->setEllipsoid(Ellipsoid::ELLIPSOID_PZ90));
        $this->assertEquals(Ellipsoid::create(Ellipsoid::ELLIPSOID_PZ90), $point->getEllipsoid());

        $this->assertInstanceOf('PHP2GIS\GeoPoint', $point->setEllipsoid(Ellipsoid::create(Ellipsoid::ELLIPSOID_SK42)));
        $this->assertEquals(Ellipsoid::create(Ellipsoid::ELLIPSOID_SK42), $point->getEllipsoid());
    }

    public function testEqual()
    {
        $point1 = new GeoPoint(54, 27);
        $this->assertTrue($point1->isEqual($point1));

        $point2 = new GeoPoint(54, 27.1);

        $WGS84 = Ellipsoid::ELLIPSOID_WGS84;
        $PZ90  = Ellipsoid::ELLIPSOID_PZ90;

        $tests = [
        //  result, lat point 1  , long point 1 , lat point 2  , long point 2, Ellipsoid 1, Ellipsoid 2,
            [false, 54           , 27           , 54           , 27.1         , $WGS84    , $WGS84     ,],
            [true , 54.1234567895, 27.1234567895, 54.1234567892, 27.1234567891, $WGS84    , $WGS84     ,],
            [false, 54.1234567895, 27.1234567895, 54.1234567892, 27.12345678  , $WGS84    , $WGS84     ,],
            [false, 54.1234567895, 27.1234567895, 54.12345678  , 27.1234567891, $WGS84    , $WGS84     ,],
            [false, 54.1234567895, 27.12345678  , 54.1234567892, 27.1234567891, $WGS84    , $WGS84     ,],
            [false, 54.12345678  , 27.1234567895, 54.1234567892, 27.1234567891, $WGS84    , $WGS84     ,],
            [false, 54.12345678  , 27.1234567895, 54.1234567892, 27.12345678  , $WGS84    , $WGS84     ,],
            [true , 54.12345678  , 27.1234567895, 54.12345678  , 27.1234567891, $WGS84    , $WGS84     ,],
            [true , 54.1234567895, 27.12345678  , 54.1234567892, 27.12345678  , $WGS84    , $WGS84     ,],
            [false, 54.12345678  , 27.12345678  , 54.1234567892, 27.1234567891, $WGS84    , $WGS84     ,],
            [false, 54.12345678  , 27.12345678  , 54.1234567892, 27.12345678  , $WGS84    , $WGS84     ,],
            [false, 54.12345678  , 27.12345678  , 54.12345678  , 27.1234567891, $WGS84    , $WGS84     ,],
            [true , 54.12345678  , 27.12345678  , 54.12345678  , 27.12345678  , $WGS84    , $WGS84     ,],
            [false, 54.1234567895, 27.1234567895, 54.1234567892, 27.1234567891, $WGS84    , $PZ90      ,],
        ];

        foreach ($tests as $test) {
            $point1->getLatitude()->setFloatValue($test[1]);
            $point1->getLongitude()->setFloatValue($test[2]);
            $point1->setEllipsoid($test[5]);
            $point2->getLatitude()->setFloatValue($test[3]);
            $point2->getLongitude()->setFloatValue($test[4]);
            $point2->setEllipsoid($test[6]);

            if ($test[0]) {
                $this->assertTrue($point1->isEqual($point2));
                $this->assertTrue($point2->isEqual($point1));
            } else {
                $this->assertFalse($point1->isEqual($point2));
                $this->assertFalse($point2->isEqual($point1));
            }
        }
    }
}
