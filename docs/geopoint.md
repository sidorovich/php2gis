### GeoPoint

This model for operate points on ellipsoid. Main parameters: latitude, longitude and ellipsoid.

Ellipsoid is necessary parameter, by default using WSG-84. If you need another - you can set it only in constructor.

You can not change ellipsoid in objects after creating.

You can not use geo points on different ellipsoids for compare, for creating lines and other.

Every GeoPoint object maybe converted to GeoJSON format by calling method `toGeoJson`

Method `getLatitude` return object of [`Latitude`](latitude.md), and `getLongitude` return object of [`Longitude`](longitude.md).


```php
<?php

use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Longitude;
use PHP2GIS\Ellipsoid;
use PHP2GIS\GeoPoint;

$point1 = new GeoPoint(54.5, 38.9); // default ellipsoid WGS-84

$point2 = new GeoPoint(new Latitude(54.5), new Longitude(38.9), Ellipsoid::ELLIPSOID_PZ90);

$point1->isEqual($point2); // false, same coordinates, but different ellipsoids

$geoJson = $point1->toGeoJson(); // return associative array in GeoJSON format
// use json_encode() if you need get string
```