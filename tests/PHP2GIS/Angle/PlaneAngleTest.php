<?php

use PHP2GIS\Angle\PlaneAngle;

/**
 * Class PlaneAngleTest
 *
 * @package PHP2GIS\Angle
 * @since   2014-10-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class PlaneAngleTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateFloatValue()
    {
        $angle = new PlaneAngle(0);
        $this->assertInstanceOf('PHP2GIS\Angle\PlaneAngle', $angle);
        $this->assertEquals(0.0, $angle->getFloatValue());

        $angle->setFloatValue(360);
        $this->assertEquals(360, $angle->getFloatValue());
    }

    public function testBelowMinimumFloatValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $angle = new PlaneAngle(-1);
    }

    public function testAboveMaximumFloatValue()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $angle = new PlaneAngle(360.5);
    }
}
