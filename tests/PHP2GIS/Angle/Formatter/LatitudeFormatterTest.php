<?php

use PHP2GIS\Angle\Formatter\LatitudeFormatter;
use PHP2GIS\Angle\Latitude;

class LatitudeFormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testLatitudeFormatter()
    {
        $SIGNS  = LatitudeFormatter::TEMPLATE_DDMMSS_SIGNS;
        $SPACES = LatitudeFormatter::TEMPLATE_DDMMSS_SPACES;
        $DOTS   = LatitudeFormatter::TEMPLATE_DDDMMSSs_DOTS;

        $LEADING = LatitudeFormatter::SYMBOL_LEADING;
        $ENDING  = LatitudeFormatter::SYMBOL_ENDING;

        $testCases = array(
            array( 65.881598403622, $SPACES, $LEADING, 'N65 52 54'  ),
            array( 14.399535201676, $SPACES, $ENDING ,  '14 23 58N' ),
            array(-21.937607457832, $SIGNS , $LEADING, 'S21°56′15″' ),
            array(-27.464192433965, $SIGNS , $ENDING ,  '27°27′51″S'),
            array( 45.996151285244, $SPACES, $LEADING, 'N45 59 46'  ),
            array(  9.730811612555, $SPACES, $ENDING ,  '09 43 51N' ),
            array(-17.157315624485, $SIGNS , $LEADING, 'S17°09′26″' ),
            array( 44.90099268728 , $SIGNS , $ENDING ,  '44°54′04″N'),
            array(-12.42348032185 , $SPACES, $ENDING ,  '12 25 25S' ),
            array( 23.223130224842, $SIGNS , $LEADING, 'N23°13′23″' ),
            array(  0.0           , $SPACES, $LEADING, 'N00 00 00'  ),
            array( -0.0           , $SPACES, $ENDING ,  '00 00 00N' ),

            // DDD.MM.SS.sss Format

            array(-84.179543403061, $DOTS  , $LEADING, 'S084.10.46.356',),
            array(-35.194720479285, $DOTS  , $LEADING, 'S035.11.40.994',),
            array( 70.758686634134, $DOTS  , $LEADING, 'N070.45.31.272',),
            array(-34.054819785084, $DOTS  , $LEADING, 'S034.03.17.351',),
            array( 35.364012543747, $DOTS  , $LEADING, 'N035.21.50.445',),
            array( 89.494085591051, $DOTS  , $LEADING, 'N089.29.38.708',),
            array(  0.0           , $DOTS  , $LEADING, 'N000.00.00.000',),
            array( -0.0           , $DOTS  , $LEADING, 'N000.00.00.000',),
        );

        foreach ($testCases as $test) {
            $formatter = new LatitudeFormatter($test[1], $test[2]);
            $angle = new Latitude($test[0]);
            $this->assertEquals($test[3], $angle->format($formatter));
        }
    }
}
