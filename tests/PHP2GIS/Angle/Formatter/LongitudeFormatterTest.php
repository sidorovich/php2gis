<?php

use PHP2GIS\Angle\Formatter\LongitudeFormatter;
use PHP2GIS\Angle\Longitude;

class LongitudeFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testLongitudeFormatter()
    {
        $SIGNS  = LongitudeFormatter::TEMPLATE_DDMMSS_SIGNS;
        $SPACES = LongitudeFormatter::TEMPLATE_DDMMSS_SPACES;
        $DOTS   = LongitudeFormatter::TEMPLATE_DDDMMSSs_DOTS;

        $LEADING = LongitudeFormatter::SYMBOL_LEADING;
        $ENDING  = LongitudeFormatter::SYMBOL_ENDING;

        $testCases = array(
            array(  30.801423923486   , $SPACES, $LEADING, 'E030 48 05'  ,),
            array( -17.75262223452    , $SPACES, $ENDING ,  '017 45 09W' ,),
            array(  -8.6213489196363  , $SIGNS , $LEADING, 'W008°37′17″' ,),
            array(-113.94879298934    , $SIGNS , $ENDING ,  '113°56′56″W',),
            array( -22.465409656272   , $SPACES, $LEADING, 'W022 27 55'  ,),
            array( -57.22785455977    , $SPACES, $ENDING ,  '057 13 40W' ,),
            array(  24.621459285087   , $SIGNS , $LEADING, 'E024°37′17″' ,),
            array( 150.85429640992    , $SIGNS , $ENDING ,  '150°51′15″E',),
            array(-153.23668290546    , $SPACES, $LEADING, 'W153 14 12'  ,),
            array( -39.106584572749   , $SPACES, $ENDING ,  '039 06 24W' ,),
            array( 166.02008487378    , $SIGNS , $LEADING, 'E166°01′12″' ,),
            array(   0.033349832535407, $SIGNS , $ENDING ,  '000°02′00″E',),
            array(   0.0              , $SPACES, $LEADING, 'E000 00 00'  ,),
            array(  -0.0              , $SIGNS , $ENDING ,  '000°00′00″E',),

            // DDD.MM.SS.sss Format

            array( -51.012257109868   , $DOTS  , $LEADING, 'W051.00.44.126',),
            array(  -3.911575630266   , $DOTS  , $LEADING, 'W003.54.41.672',),
            array(  41.612938745698   , $DOTS  , $LEADING, 'E041.36.46.579',),
            array(-119.12263504189    , $DOTS  , $LEADING, 'W119.07.21.486',),
            array( -87.578980432627   , $DOTS  , $LEADING, 'W087.34.44.330',),
            array(  85.636183519678   , $DOTS  , $LEADING, 'E085.38.10.261',),
            array(  14.210918449895   , $DOTS  , $LEADING, 'E014.12.39.306',),
            array(  82.27291821608    , $DOTS  , $LEADING, 'E082.16.22.506',),
            array(   0.0              , $DOTS  , $LEADING, 'E000.00.00.000',),
            array(  -0.0              , $DOTS  , $LEADING, 'E000.00.00.000',),
        );

        foreach ($testCases as $test) {
            $formatter = new LongitudeFormatter($test[1], $test[2]);
            $angle = new Longitude($test[0]);
            $this->assertEquals($test[3], $angle->format($formatter));
        }
    }
}
