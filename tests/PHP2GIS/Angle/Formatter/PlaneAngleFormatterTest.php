<?php

use PHP2GIS\Angle\Formatter\PlaneAngleFormatter;
use PHP2GIS\Angle\PlaneAngle;

/**
 * Class PlaneAngleFormatterTest
 *
 * @package PHP2GIS
 * @since   2014-12-04
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class PlaneAngleFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidFormat()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $formatter = new PlaneAngleFormatter(-1);
    }

    public function testFormatter()
    {
        $testCases = [
            [  1.23456789  , PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES,   '1 14 04' ],
            [  1.23456789  , PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS ,   '1°14′04″'],
            [  0           , PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES,   '0 00 00' ],
            [  0           , PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS ,   '0°00′00″'],
            [ 25.5         , PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES,  '25 30 00' ],
            [ 25.5         , PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS ,  '25°30′00″'],
            [228.4502212795, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '228 27 01' ],
            [195.7969994709, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '195°47′49″'],
            [144.5310343722, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '144 31 52' ],
            [136.8303259524, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '136°49′49″'],
            [310.6613480037, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '310 39 41' ],
            [131.4872569561, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '131°29′14″'],
            [247.6242425296, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '247 37 27' ],
            [308.3828028982, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '308°22′58″'],
            [174.0842903273, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '174 05 03' ],
            [110.6685814975, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '110°40′07″'],
            [208.2350497259, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '208 14 06' ],
            [345.5722184334, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '345°34′20″'],
            [335.8657720786, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '335 51 57' ],
            [192.1757964578, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '192°10′33″'],
            [194.8284722353, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '194 49 43' ],
            [329.1944833136, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '329°11′40″'],
            [206.1133293202, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '206 06 48' ],
            [350.1937110679, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '350°11′37″'],
            [132.4560995771, PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES, '132 27 22' ],
            [244.6908432271, PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS , '244°41′27″'],
        ];

        foreach ($testCases as $test) {
            $formatter = new PlaneAngleFormatter($test[1]);
            $angle = new PlaneAngle($test[0]);
            $this->assertEquals($test[2], $angle->format($formatter));
        }
    }
}
