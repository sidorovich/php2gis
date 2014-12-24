<?php

namespace PHP2GIS;

use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Longitude;
use PHP2GIS\Exception\MismatchEllipsoidException;

/**
 * Class Dimensions
 *
 * @package PHP2GIS
 * @since   2014-12-08
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class Dimensions implements GeoJsonConvertibleInterface
{
    /**
     * @var Ellipsoid
     */
    protected $ellipsoid;

    /**
     * @var Longitude
     */
    protected $westBorder;

    /**
     * @var Longitude
     */
    protected $eastBorder;

    /**
     * @var Latitude
     */
    protected $northBorder;

    /**
     * @var Latitude
     */
    protected $southBorder;

    /**
     * @var VincentyCalculator
     */
    protected $calculator;

    /**
     * @return Longitude
     */
    public function getWestBorder()
    {
        return $this->westBorder;
    }

    /**
     * @return Longitude
     */
    public function getEastBorder()
    {
        return $this->eastBorder;
    }

    /**
     * @return Latitude
     */
    public function getNorthBorder()
    {
        return $this->northBorder;
    }

    /**
     * @return Latitude
     */
    public function getSouthBorder()
    {
        return $this->southBorder;
    }

    /**
     * @param GeoPoint $point
     * @return $this
     * @throws MismatchEllipsoidException
     */
    public function expandGeoPoint(GeoPoint $point)
    {
        if (is_null($this->ellipsoid)) {
            $this->ellipsoid = $point->getEllipsoid();
        } elseif ($this->ellipsoid != $point->getEllipsoid()) {
            throw new MismatchEllipsoidException('Invalid ellipsoid in point during dimensions calculation');
        };

        $this
            ->expandWestBorder($point)
            ->expandEastBorder($point)
            ->expandNorthBorder($point)
            ->expandSouthBorder($point)
        ;

        return $this;
    }

    /**
     * @param GeoLine $line
     * @return $this
     */
    public function expandGeoLine(GeoLine $line)
    {
        $this->expandGeoPoint($line->getStart());
        $this->expandGeoPoint($line->getEnd());

        return $this;
    }

    /**
     * @return VincentyCalculator
     */
    protected function getCalculator()
    {
        if (!$this->calculator) {
            $this->calculator = new VincentyCalculator();
        }

        return $this->calculator;
    }

    /**
     * @param GeoPoint $point
     * @return $this
     * @throws MismatchEllipsoidException
     */
    protected function expandWestBorder(GeoPoint $point)
    {
        $calculator = $this->getCalculator();

        if (is_null($this->westBorder)) {
            $this->westBorder = $point->getLongitude();
        } else {
            $borderPoint = new GeoPoint($point->getLatitude(), $this->westBorder, $this->ellipsoid);
            $calculator->inverseCalculation($point, $borderPoint);
            $bearing = $calculator->getInitialBearing();
            if ($bearing and ($bearing->getFloatValue() >= 0) and ($bearing->getFloatValue() <= 180)) {
                $this->westBorder = $point->getLongitude();
            }
        }

        return $this;
    }

    /**
     * @param GeoPoint $point
     * @return $this
     * @throws MismatchEllipsoidException
     */
    protected function expandEastBorder(GeoPoint $point)
    {
        $calculator = $this->getCalculator();

        if (is_null($this->eastBorder)) {
            $this->eastBorder = $point->getLongitude();
        } else {
            $borderPoint = new GeoPoint($point->getLatitude(), $this->eastBorder, $this->ellipsoid);
            $calculator->inverseCalculation($point, $borderPoint);
            $bearing = $calculator->getInitialBearing();
            if ($bearing and ($bearing->getFloatValue() >= 180) and ($bearing->getFloatValue() <= 360)) {
                $this->eastBorder = $point->getLongitude();
            }
        }

        return $this;
    }

    /**
     * @param GeoPoint $point
     * @return $this
     * @throws MismatchEllipsoidException
     */
    protected function expandNorthBorder(GeoPoint $point)
    {
        $calculator = $this->getCalculator();

        if (is_null($this->northBorder)) {
            $this->northBorder = $point->getLatitude();
        } else {
            $borderPoint = new GeoPoint($this->northBorder, $point->getLongitude(), $this->ellipsoid);
            $calculator->inverseCalculation($point, $borderPoint);
            $bearing = $calculator->getInitialBearing();
            if ($bearing and ($bearing->getFloatValue() >= 90) and ($bearing->getFloatValue() <= 270)) {
                $this->northBorder = $point->getLatitude();
            }
        }

        return $this;
    }

    /**
     * @param GeoPoint $point
     * @return $this
     * @throws MismatchEllipsoidException
     */
    protected function expandSouthBorder(GeoPoint $point)
    {
        $calculator = $this->getCalculator();

        if (is_null($this->southBorder)) {
            $this->southBorder = $point->getLatitude();
        } else {
            $borderPoint = new GeoPoint($this->southBorder, $point->getLongitude(), $this->ellipsoid);
            $calculator->inverseCalculation($point, $borderPoint);
            $bearing = $calculator->getInitialBearing();
            if ($bearing and ($bearing->getFloatValue() >= 270) or ($bearing->getFloatValue() <= 90)) {
                $this->southBorder = $point->getLatitude();
            }
        }

        return $this;
    }

    /**
     * Return associative array for encode to GeoJSON format
     *
     * @return array
     */
    public function toGeoJson()
    {
        return array(
            'type'        => 'MultiPoint',
            'coordinates' => array(
                array($this->southBorder->getFloatValue(), $this->westBorder->getFloatValue()),
                array($this->northBorder->getFloatValue(), $this->eastBorder->getFloatValue()),
            ),
        );
    }
}
