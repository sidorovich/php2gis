<?php

use PHP2GIS\Angle\Longitude;

/**
 * Class LongitudeTest
 *
 * @package PHP2GIS\Angle
 * @since   2014-12-02
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class LongitudeTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateFloatValue()
    {
        $angle = new Longitude(0);
        $this->assertInstanceOf('PHP2GIS\Angle\Longitude', $angle);
        $this->assertEquals(0.0, $angle->getFloatValue());

        $angle->setFloatValue(-180.0);
        $this->assertEquals(-180.0, $angle->getFloatValue());

        $angle->setFloatValue(180.0);
        $this->assertEquals(180.0, $angle->getFloatValue());
    }

    public function testBelowMinimumFloatValue()
    {
        $this->setExpectedException('PHP2GIS\Exception\InvalidArgumentException');
        $angle = new Longitude(-180.01);
    }

    public function testAboveMaximumFloatValue()
    {
        $this->setExpectedException('PHP2GIS\Exception\InvalidArgumentException');
        $angle = new Longitude(180.001);
    }
}
