<?php

namespace PHP2GIS;

use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Longitude;

/**
 * Class GeoPoint
 *
 * @package PHP2GIS
 * @since   2014-12-02
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class GeoPoint implements GeoJsonConvertableInterface
{
    /**
     * @var Latitude
     */
    protected $latitude;

    /**
     * @var Longitude
     */
    protected $longitude;

    /**
     * @var Ellipsoid
     */
    protected $ellipsoid;

    /**
     * Create geo-point
     *
     * @param float|Latitude   $latitude
     * @param float|Longitude  $longitude
     * @param string|Ellipsoid $ellipsoid
     */
    public function __construct($latitude, $longitude, $ellipsoid = Ellipsoid::ELLIPSOID_WGS84)
    {
        $this
            ->setLatitude($latitude)
            ->setLongitude($longitude)
            ->setEllipsoid($ellipsoid)
        ;
    }

    /**
     * Set latitude
     *
     * @param float|Latitude $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        if ($latitude instanceof Latitude) {
            $this->latitude = $latitude;
        } else {
            $this->latitude = new Latitude($latitude);
        }

        return $this;
    }

    /**
     * Get latitude
     *
     * @return Latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float|Longitude $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        if ($longitude instanceof Longitude) {
            $this->longitude = $longitude;
        } else {
            $this->longitude = new Longitude($longitude);
        }

        return $this;
    }

    /**
     * Get longitude
     *
     * @return Longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * True if 2 points have an equal coordinates on the same ellipsoid
     *
     * @param GeoPoint $point
     * @return bool
     */
    public function isEqual(GeoPoint $point)
    {
        return $this->ellipsoid == $point->getEllipsoid()
            and $this->latitude->isEqual($point->getLatitude())
            and $this->longitude->isEqual($point->getLongitude());
    }

    /**
     * Set ellipsoid
     *
     * @param string|Ellipsoid $ellipsoid
     * @return $this
     */
    protected function setEllipsoid($ellipsoid)
    {
        if ($ellipsoid instanceof Ellipsoid) {
            $this->ellipsoid = $ellipsoid;
        } else {
            $this->ellipsoid = Ellipsoid::create($ellipsoid);
        }

        return $this;
    }

    /**
     * Get ellipsoid
     *
     * @return Ellipsoid
     */
    public function getEllipsoid()
    {
        return $this->ellipsoid;
    }

    /**
     * Return associative array for encode to GeoJSON format
     *
     * @return array
     */
    public function toGeoJson()
    {
        return array(
            'type'        => 'Point',
            'coordinates' => array($this->latitude->getFloatValue(), $this->longitude->getFloatValue()),
        );
    }
}
