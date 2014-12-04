<?php

namespace PHP2GIS;

use PHP2GIS\Angle\PlaneAngle;

/**
 * Class VincentyCalculator
 *
 * @see http://www.movable-type.co.uk/scripts/latlong-vincenty.html
 *
 * @package PHP2GIS\Distance
 * @since   2014-12-03
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
class VincentyCalculator
{
    protected $precision = 1e-12;

    protected $iterationsLimit = 200;

    /**
     * @var PlaneAngle
     */
    protected $initialBearing;

    /**
     * @var PlaneAngle
     */
    protected $finalBearing;

    /**
     * @return PlaneAngle
     */
    public function getInitialBearing()
    {
        return $this->initialBearing;
    }

    /**
     * @return PlaneAngle
     */
    public function getFinalBearing()
    {
        return $this->finalBearing;
    }

    /**
     * Vincenty inverse calculation
     *
     * @param GeoPoint $point1
     * @param GeoPoint $point2
     * @return float // meters
     */
    public function inverseCalculation(GeoPoint $point1, GeoPoint $point2)
    {
        if ($point1->getEllipsoid() != $point2->getEllipsoid()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Impossible to calculate the distance between two points on different ellipsoids [%s, %s]',
                    $point1->getEllipsoid()->getName(), $point2->getEllipsoid()->getName()
                )
            );
        }

        $lat1 = $point1->getLatitude()->getRadians();
        $lon1 = $point1->getLongitude()->getRadians();
        $lat2 = $point2->getLatitude()->getRadians();
        $lon2 = $point2->getLongitude()->getRadians();
        $ellipsoid = $point1->getEllipsoid();
        $a = $ellipsoid->getA();
        $b = $ellipsoid->getB();
        $f = 1 / $ellipsoid->getF();

        $L = $lon2 - $lon1;

        $tanU1 = (1 - $f) * tan($lat1);
        $cosU1 = 1 / sqrt(1 + $tanU1 * $tanU1);
        $sinU1 = $tanU1 * $cosU1;

        $tanU2 = (1 - $f) * tan($lat2);
        $cosU2 = 1 / sqrt(1 + $tanU2 * $tanU2);
        $sinU2 = $tanU2 * $cosU2;

        $lambda = $L;
        $iteration = 0;

        do {

            $sinLambda = sin($lambda);
            $cosLambda = cos($lambda);

            $sinSigma = sqrt(
                ($cosU2 * $sinLambda) * ($cosU2 * $sinLambda)
                + ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda)
            );

            if ($sinSigma == 0) {
                return 0;
            }

            $cosSigma = ($sinU1 * $sinU2) + ($cosU1 * $cosU2 * $cosLambda);
            $sigma = atan2($sinSigma, $cosSigma);
            $sinAlpha = $cosU1 * $cosU2 * $sinLambda / $sinSigma;
            $cosSqAlpha = 1 - $sinAlpha * $sinAlpha;

            if ($cosSqAlpha == 0) {
                $cos2sigmaM = 0;
            } else {
                $cos2sigmaM = $cosSigma - 2 * $sinU1 * $sinU2 / $cosSqAlpha;
            }

            $C = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));
            $prevLambda = $lambda;

            $lambda = $L + (1 - $C) * $f * $sinAlpha
                * ($sigma + $C * $sinSigma * ($cos2sigmaM + $C * $cosSigma * (-1 + 2 * $cos2sigmaM * $cos2sigmaM)));

        } while ((abs($lambda - $prevLambda) > $this->precision) && (++$iteration < $this->iterationsLimit));

        $uSq        = $cosSqAlpha * ($a * $a - $b * $b) / ($b * $b);
        $A          = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
        $B          = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));
        $deltaSigma = $B * $sinSigma * ($cos2sigmaM + $B / 4 * ($cosSigma * (-1 + 2 * $cos2sigmaM * $cos2sigmaM)
                    - $B / 6 * $cos2sigmaM * (-3 + 4 * $sinAlpha * $sinAlpha) * (-3 + 4 * $cos2sigmaM * $cos2sigmaM)));

        $s = $b * $A * ($sigma - $deltaSigma);

        $alpha1 = atan2($cosU2 * $sinLambda,  $cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda);
        $alpha2 = atan2($cosU1 * $sinLambda, -$sinU1 * $cosU2 + $cosU1 * $sinU2 * $cosLambda);

        $alpha1 = ($alpha1 + 2 * M_PI) % (2 * M_PI);
        $alpha2 = ($alpha2 + 2 * M_PI) % (2 * M_PI);

        $this->initialBearing = new PlaneAngle();
        $this->initialBearing->setRadians($alpha1);
        $this->finalBearing = new PlaneAngle();
        $this->finalBearing->setRadians($alpha2);

        return round($s, 4);
    }
}
