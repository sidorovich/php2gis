### Latitude

This class extends [PlainAngle](plain-angle.md)

All operations is the same, because latitude is just angle in spherical coordinate system

Valid values for latitude [-90..90] degrees.

If you try set invalid value you got `PHP2GIS\Exception\InvalidArgumentException`

Positive value using for north latitude (N), and negative value using for west latitude (E).

And you must remember, that you can not compare `Latitude`, `Longitude` and `PlaneAngle`

```php
<?php

use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Longitude;
use PHP2GIS\Angle\PlaneAngle;

$lat = new Latitude(90.0);
$lon = new Longitude(90.0);
$angle = new PlaneAngle(90.0);

$lat->isEqual($lon);   // false
$lat->isEqual($angle); // false
$angle->isEqual($lat); // false
```

