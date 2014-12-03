<?php

namespace PHP2GIS;

/**
 * Class Ellipsoid
 *
 * This class based on realization from Marcus T. Jaschen
 * https://github.com/mjaschen/phpgeo/blob/master/src/Location/Ellipsoid.php
 *
 * @package PHP2GIS
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class Ellipsoid
{
    const ELLIPSOID_WGS84 = 'WGS84';
    const ELLIPSOID_GRS80 = 'GRS80';
    const ELLIPSOID_PZ90  = 'PZ-90';
    const ELLIPSOID_SK42  = 'SK-42';

    /**
     * @var string
     */
    protected $name;

    /**
     * The semi-major axis (meters)
     *
     * @var float
     */
    protected $a;

    /**
     * The Inverse Flattening (1/f)
     *
     * @var float
     */
    protected $f;

    /**
     * Some often used ellipsoids
     *
     * @var array
     */
    protected static $ELLIPSOIDS = [

        /**
         * @see  https://en.wikipedia.org/wiki/World_Geodetic_System
         */

        self::ELLIPSOID_WGS84 => [
            'name' => self::ELLIPSOID_WGS84,
            'a'    => 6378137.0,
            'f'    => 298.257223563,
        ],

        self::ELLIPSOID_GRS80 => [
            'name' => self::ELLIPSOID_GRS80,
            'a'    => 6378137.0,
            'f'    => 298.257222100882711,
        ],

        /**
         * @see  https://ru.wikipedia.org/wiki/%D0%9F%D0%97-90
         * using for GLONASS https://en.wikipedia.org/wiki/GLONASS
         */

        self::ELLIPSOID_PZ90 => [
            'name' => self::ELLIPSOID_PZ90,
            'a'    => 6378136.0,
            'f'    => 298.257839303,
        ],

        /**
         * @see  https://en.wikipedia.org/wiki/SK-42_reference_system
         */

        self::ELLIPSOID_SK42 => [
            'name' => self::ELLIPSOID_SK42,
            'a'    => 6378245.0,
            'f'    => 298.3,
        ],
    ];

    /**
     * @param string $name
     * @param float  $a
     * @param float  $f
     */
    public function __construct($name, $a, $f)
    {
        $this->name = $name;
        $this->a    = $a;
        $this->f    = $f;
    }

    /**
     * @param string $name
     *
     * @return Ellipsoid
     */
    public static function create($name = self::ELLIPSOID_WGS84)
    {
        if (isset(self::$ELLIPSOIDS[$name])) {
            return self::createFromArray(self::$ELLIPSOIDS[$name]);
        } else {
            throw new \InvalidArgumentException('Non-exists ellipsoid name ' . $name);
        }
    }

    /**
     * @param array $ellipsoidData
     *
     * @return Ellipsoid
     */
    public static function createFromArray($ellipsoidData)
    {
        if (empty($ellipsoidData['name']) || !isset($ellipsoidData['a']) || !isset($ellipsoidData['f'])) {
            throw new \InvalidArgumentException('Invalid ellipsoid data');
        }
        return new self($ellipsoidData['name'], doubleval($ellipsoidData['a']), doubleval($ellipsoidData['f']));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Calculation of the semi-minor axis
     *
     * @return float
     */
    public function getB()
    {
        return $this->a * (1 - 1 / $this->f);
    }

    /**
     * @return float
     */
    public function getF()
    {
        return $this->f;
    }

    /**
     * Calculates the arithmetic mean radius
     *
     * @see http://home.online.no/~sigurdhu/WGS84_Eng.html
     *
     * @return float
     */
    public function getArithmeticMeanRadius()
    {
        return $this->a * (1 - 1 / $this->f / 3);
    }
}
