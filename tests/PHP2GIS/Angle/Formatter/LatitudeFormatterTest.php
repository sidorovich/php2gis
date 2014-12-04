<?php

use PHP2GIS\Angle\Formatter\LatitudeFormatter;
use PHP2GIS\Angle\Latitude;

class LatitudeFormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testLatitudeFormatter()
    {
        $formatter = new LatitudeFormatter();

        $SIGNS  = LatitudeFormatter::TEMPLATE_DDMMSS_SIGNS;
        $SPACES = LatitudeFormatter::TEMPLATE_DDMMSS_SPACES;

        $LEADING = LatitudeFormatter::SYMBOL_LEADING;
        $ENDING  = LatitudeFormatter::SYMBOL_ENDING;

        $testCases = [
            [ 65.881598403622, $SPACES, $LEADING, 'N65 52 54'  ],
            [ 14.399535201676, $SPACES, $ENDING ,  '14 23 58N' ],
            [-21.937607457832, $SIGNS , $LEADING, 'S21°56′15″' ],
            [-27.464192433965, $SIGNS , $ENDING ,  '27°27′51″S'],
            [ 45.996151285244, $SPACES, $LEADING, 'N45 59 46'  ],
            [  9.730811612555, $SPACES, $ENDING ,  '09 43 51N' ],
            [-17.157315624485, $SIGNS , $LEADING, 'S17°09′26″' ],
            [ 44.90099268728 , $SIGNS , $ENDING ,  '44°54′04″N'],
            [-12.42348032185 , $SPACES, $ENDING ,  '12 25 25S' ],
            [ 23.223130224842, $SIGNS , $LEADING, 'N23°13′23″' ],
            [  0.0           , $SPACES, $LEADING, 'N00 00 00'  ],
            [ -0.0           , $SPACES, $ENDING,   '00 00 00N' ],
        ];

        foreach ($testCases as $test) {
            $angle = new Latitude($test[0]);
            $this->assertEquals($test[3], $formatter->formatAngle($angle, $test[1], $test[2]));
        }
    }
}
