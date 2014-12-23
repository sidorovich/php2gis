### GeoLine

**It's not line in 3D-space, it's arc on ellipsoid surface!**

For start and end of lines using objects of [`GeoPoint`](geopoint.md)

Line may change start and end, but start and end point must be on the same Ellipsoid.

If you try to use points on different ellipsoids, you got `PHP2GIS\Exception\MismatchEllipsoidException`

You can calculate distance, initial (true, not magnetic) and final (true, not magnetic) bearings between start and end of line.

Distance and bearings calculated once together by calling getter and save in object. 
Saved result of calculation will be unset after changing start or end point, and will be recalculated 
after next calling getter for distance or bearings.

Distances will be returned in meters as float value.

Bearings will be returned as [PlaneAngle](plain-angle.md) objects or `NULL` if impossible to calculate it.

Bearings may be different, because using great-circle or orthodromic calculation by [Vincenty's formula](https://en.wikipedia.org/wiki/Vincenty%27s_formulae)  

Every GeoLine object maybe converted to GeoJSON format by calling method `toGeoJson`

```php
<?php

use PHP2GIS\Ellipsoid;
use PHP2GIS\GeoLine;
use PHP2GIS\GeoPoint;

$line = new GeoLine(
    new GeoPoint(53.8913888889, 29.1697222222), 
    new GeoPoint(54.035, 29.3013888889)
);

echo $line->getDistance();           
// 18170.9963601 (in meters)

print_r($line->getInitialBearing()); 
// PlaneAngle object with value 28.3438722192

print_r($line->getFinalBearing());   
// PlaneAngle object with value 28.4503431534

$line->setStart(
    new GeoPoint(53.8913888889, 29.1697222222, Ellipsoid::ELLIPSOID_PZ90)
);
// you got PHP2GIS\Exception\MismatchEllipsoidException
// because in GeoLine object stored end-point on WGS-84 default datum
```