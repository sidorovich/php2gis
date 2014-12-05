<?php

namespace PHP2GIS;

use PHP2GIS\Angle\PlaneAngle;
use PHP2GIS\Exception\MismatchEllipsoidException;

/**
 * Class GeoLine
 *
 * @package PHP2GIS
 * @since   2014-12-05
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class GeoLine
{

    const EXCEPTION_MESSAGE_MISMATCH_ELLIPSOIDS = 'Impossible to use different ellipsoids for points of one line';

    /**
     * @var GeoPoint
     */
    protected $start;

    /**
     * @var GeoPoint
     */
    protected $end;

    /**
     * @var bool
     */
    protected $isCalculated = false;

    /**
     * @var float
     */
    protected $distance;

    /**
     * @var PlaneAngle|null
     */
    protected $initialBearing;

    /**
     * @var PlaneAngle|null
     */
    protected $finalBearing;

    /**
     * Create Line object
     *
     * It's not the line on plane! It's arc of ellipsoid!
     *
     * @param GeoPoint $start
     * @param GeoPoint $end
     *
     * @throws MismatchEllipsoidException
     */
    public function __constructor(GeoPoint $start, GeoPoint $end)
    {
        if ($start->getEllipsoid() != $end->getEllipsoid()) {
            throw new MismatchEllipsoidException(self::EXCEPTION_MESSAGE_MISMATCH_ELLIPSOIDS);
        }

        $this->setStart($start);
        $this->setEnd($end);
    }

    /**
     * Change start point of line
     *
     * @param GeoPoint $start
     * @return $this
     *
     * @throws MismatchEllipsoidException
     */
    public function setStart(GeoPoint $start)
    {
        if ($this->end && $this->end->getEllipsoid() != $start->getEllipsoid()) {
            throw new MismatchEllipsoidException(self::EXCEPTION_MESSAGE_MISMATCH_ELLIPSOIDS);
        }

        $this->isCalculated = $start == $this->start;
        $this->start = $start;

        return $this;
    }

    /**
     * Get start point of line
     *
     * @return GeoPoint
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Change end of line
     *
     * @param GeoPoint $end
     * @return $this
     *
     * @throws MismatchEllipsoidException
     */
    public function setEnd(GeoPoint $end)
    {
        if ($this->start && $this->start->getEllipsoid() != $end->getEllipsoid()) {
            throw new MismatchEllipsoidException(self::EXCEPTION_MESSAGE_MISMATCH_ELLIPSOIDS);
        }

        $this->isCalculated = $end == $this->end;
        $this->end = $end;

        return $this;
    }

    /**
     * Get end point of line
     *
     * @return GeoPoint
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get distance on ellipsoid between start and end
     *
     * Ellipsoid will be get from any point of line
     *
     * @return float // in meters
     */
    public function getDistance()
    {
        if (!$this->isCalculated) {
            $this->calculateParameters();
        }

        return $this->distance;
    }

    /**
     * Get true initial bearing from start to end point
     *
     * Return NULL if impossible to calculate bearing (for example, the same points)
     *
     * @return null|PlaneAngle
     */
    public function getInitialBearing()
    {
        if (!$this->isCalculated) {
            $this->calculateParameters();
        }

        return $this->initialBearing;
    }

    /**
     * Get true final bearing from start to end point
     *
     * Return NULL if impossible to calculate bearing (for example, the same points)
     *
     * @return null|PlaneAngle
     */
    public function getFinalBearing()
    {
        if (!$this->isCalculated) {
            $this->calculateParameters();
        }

        return $this->finalBearing;
    }

    /**
     * Calculate distance
     *
     * @return $this

     */
    protected function calculateParameters()
    {
        $calculator = new VincentyCalculator();

        $this->distance       = $calculator->inverseCalculation($this->start, $this->end);
        $this->initialBearing = $calculator->getInitialBearing();
        $this->finalBearing   = $calculator->getFinalBearing();

        $this->isCalculated = true;

        return $this;
    }
}
