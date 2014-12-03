<?php

use PHP2GIS\Ellipsoid;

/**
 * Class EllipsoidTest
 *
 * @package PHP2GIS
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class EllipsoidTest extends \PHPUnit_Framework_TestCase
{
    const PRECISION = 0.0001;

    public function testEllipsoids()
    {
        $ellipsoids = [
          // name   , Semi-major axis (A), Semi-minor axis (B), Arithmetic mean R (2A+B)/3, Inverse Flattening (1/f),
            ['WGS84', 6378137.0          , 6356752.3142       , 6371008.7714              , 298.257223563          ],
            ['GRS80', 6378137.0          , 6356752.31414      , 6371008.77138             , 298.257222100882711    ],
            ['PZ-90', 6378136.0          , 6356751.36175      , 6371007.78725             , 298.257839303          ],
            ['SK-42', 6378245.0          , 6356863.01877      , 6371117.67292             , 298.3                  ],
        ];

        foreach ($ellipsoids as $ellipsoidData) {
            $ellipsoid = Ellipsoid::create($ellipsoidData[0]);
            $this->assertInstanceOf('PHP2GIS\Ellipsoid', $ellipsoid);

            $this->assertEquals($ellipsoidData[0], $ellipsoid->getName());
            $this->assertEquals($ellipsoidData[1], $ellipsoid->getA(), '', self::PRECISION);
            $this->assertEquals($ellipsoidData[2], $ellipsoid->getB(), '', self::PRECISION);
            $this->assertEquals($ellipsoidData[3], $ellipsoid->getArithmeticMeanRadius(), '', self::PRECISION);
            $this->assertEquals($ellipsoidData[4], $ellipsoid->getF(), '', self::PRECISION);
        }
     }

    public function testEqual()
    {
        $ellipsoids = [
            [true , 'A', 6378137, 298, 'A', 6378137, 298],
            [false, 'A', 6378137, 298, 'B', 6378137, 298],
            [false, 'A', 6378137, 298, 'A', 6378136, 298],
            [false, 'A', 6378137, 298, 'A', 6378137, 297],
        ];

        foreach ($ellipsoids as $var) {
            $ellipsoid1 = Ellipsoid::createFromArray(['name' => $var[1], 'a' => $var[2], 'f' => $var[3]]);
            $ellipsoid2 = Ellipsoid::createFromArray(['name' => $var[4], 'a' => $var[5], 'f' => $var[6]]);

            $this->assertInstanceOf('PHP2GIS\Ellipsoid', $ellipsoid1);
            $this->assertInstanceOf('PHP2GIS\Ellipsoid', $ellipsoid2);

            if ($var[0]) {
                $this->assertEquals($ellipsoid1, $ellipsoid2);
            } else {
                $this->assertNotEquals($ellipsoid1, $ellipsoid2);
            }
        }
    }

    public function testInvalidEllipsoidName()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $ellipsoid = Ellipsoid::create('FAKE_ELLIPSOID_' . uniqid());
    }

    public function testEmptyEllipsoidName()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $ellipsoid = Ellipsoid::createFromArray(['name' => '', 'a' => 6378137, 'f' => 298.257223563]);
    }

    public function testInvalidEllipsoidA()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $ellipsoid = Ellipsoid::createFromArray(['name' => 'TEST', 'f' => 298.257223563]);
    }

    public function testInvalidEllipsoidF()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $ellipsoid = Ellipsoid::createFromArray(['name' => 'TEST', 'a' => 6378137]);
    }
}
