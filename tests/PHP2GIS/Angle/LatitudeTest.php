<?php

use PHP2GIS\Angle\Latitude;

/**
 * Class LatitudeTest
 *
 * @since   2014-12-02
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class LatitudeTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateFloatValue()
    {
        $angle = new Latitude(0);
        $this->assertInstanceOf('PHP2GIS\Angle\Latitude', $angle);
        $this->assertEquals(0.0, $angle->getFloatValue());

        $angle->setFloatValue(-90.0);
        $this->assertEquals(-90.0, $angle->getFloatValue());

        $angle->setFloatValue(90.0);
        $this->assertEquals(90.0, $angle->getFloatValue());
    }

    public function testBelowMinimumFloatValue()
    {
        $this->setExpectedException('PHP2GIS\Exception\InvalidArgumentException');
        $angle = new Latitude(-90.01);
    }

    public function testAboveMaximumFloatValue()
    {
        $this->setExpectedException('PHP2GIS\Exception\InvalidArgumentException');
        $angle = new Latitude(90.001);
    }
}
