<?php

namespace PHP2GIS;

use PHP2GIS\Angle\Latitude;

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
}