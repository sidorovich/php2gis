<?php

use PHP2GIS\Angle\AbstractAngle;
use PHP2GIS\Angle\AngleFormatterInterface;
use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Longitude;
use PHP2GIS\Angle\PlaneAngle;

/**
 * Class AbstractAngleTest
 *
 * @package PHP2GIS\Angle
 * @since   2014-12-02
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class AbstractAngleTest extends \PHPUnit_Framework_TestCase
{

    public function testDegrees()
    {
        $angle = new Latitude(0);

        $angle->setDegrees(10, false);
        $this->assertEquals(10, $angle->getDegrees());
        $this->assertEquals(0, $angle->getFloatValue());

        $angle->setDegrees(-10);
        $this->assertEquals(-10.0, $angle->getDegrees());
        $this->assertEquals(-10.0, $angle->getFloatValue());
    }

    public function testMinutes()
    {
        $angle = new Latitude(54);

        $angle->setMinutes(29, false);
        $this->assertEquals(29, $angle->getMinutes());
        $this->assertEquals(54.0, $angle->getFloatValue());

        $angle->setDegrees(-54, false)
            ->setMinutes(30);
        $this->assertEquals(30, $angle->getMinutes());
        $this->assertEquals(-54.5, $angle->getFloatValue());
    }

    public function testSeconds()
    {
        $angle = new Latitude(54.5);

        $angle->setSeconds(48, false);
        $this->assertEquals(48.0, $angle->getSeconds());
        $this->assertEquals(54.5, $angle->getFloatValue());

        $angle->setSeconds(23.5);
        $this->assertEquals(23.5, $angle->getSeconds());
        $this->assertEquals(54.5065277778, $angle->getFloatValue());
    }

    public function testEqual()
    {
        $angle1 = new Latitude(54.12345678);
        $angle2 = new Latitude(54.12345678);

        $this->assertTrue($angle1->isEqual($angle1));
        $this->assertTrue($angle1->isEqual($angle2));
        $this->assertTrue($angle2->isEqual($angle1));

        $angle1->setFloatValue(54.1234567895);
        $angle2->setFloatValue(54.1234567898);
        $this->assertTrue($angle1->isEqual($angle2));
        $this->assertTrue($angle2->isEqual($angle1));

        $angle1->setFloatValue(54.12345678);
        $angle2->setFloatValue(54.123456789);
        $this->assertFalse($angle1->isEqual($angle2));
        $this->assertFalse($angle2->isEqual($angle1));

        $angle1 = new TestAngle(54.12345678);
        $angle2 = new TestAngle(54.123456789);
        $this->assertTrue($angle1->isEqual($angle2));
        $this->assertTrue($angle2->isEqual($angle1));
    }

    public function testFormat()
    {
        $angle = new Longitude(30.500123);
        $this->assertEquals($angle->getFloatValue(), $angle->format(new TestAngleFormatterInterface()));
    }

    public function testRadians()
    {
        $angle = new PlaneAngle();

        $angle->setDegrees(55, false)
            ->setMinutes(45, false)
            ->setSeconds(34);
        $this->assertEquals(0.973185894638416, $angle->getRadians());

        $angle->setDegrees(-54);
        $this->assertEquals(-0.9557326021184728, $angle->getRadians());

        $angle->setRadians(1.234567890);
        $this->assertEquals(70, $angle->getDegrees());
        $this->assertEquals(44, $angle->getMinutes());
        $this->assertEquals(7.906629736547757, $angle->getSeconds());
    }
}

class TestAngle extends Latitude
{
    const EPS = 1e-3;
}

class TestAngleFormatterInterface implements AngleFormatterInterface
{
    public function formatAngle(AbstractAngle $angle)
    {
        return $angle->getFloatValue();
    }
}
