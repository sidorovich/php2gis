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
class GeoPoint
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
     * Create geo-point
     *
     * @param float|Latitude  $latitude
     * @param float|Longitude $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    /**
     * Set latitude
     *
     * @param float|Latitude $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        if (is_object($latitude) && $latitude instanceof Latitude) {
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
        if (is_object($longitude) && $longitude instanceof Longitude) {
            $this->longitude = $longitude;
        } else {
            $this->longitude = new Longitude($longitude);
        }
        return $this;
    }

    /**
     * @return Longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param GeoPoint $point
     * @return bool
     */
    public function isEqual(GeoPoint $point)
    {
        return ($this->latitude->isEqual($point->getLatitude()) && $this->longitude->isEqual($point->getLongitude()));
    }
}