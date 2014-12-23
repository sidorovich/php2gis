### Angle formatting

For formatting angle objects using formatter classes which implements [`AngleFormatterInterface`](../src/Angle/Formatter/AngleFormatterInterface.php)

#### Plane angle formatting

```php
<?php

use PHP2GIS\Angle\PlaneAngle;
use PHP2GIS\Angle\Formatter\PlaneAngleFormatter;

$angle = new PlaneAngle(228.4502212795);
$formatter = new PlaneAngleFormatter(PlaneAngleFormatter::TEMPLATE_DDMMSS_SPACES);
echo $angle->format($formatter); // 228 27 01

$angle = new PlaneAngle(195.7969994709);
$formatter = new PlaneAngleFormatter(PlaneAngleFormatter::TEMPLATE_DDMMSS_SIGNS); 
echo $angle->format($formatter); // 195°47′49″

$angle = new PlaneAngle(85.636183519678);
$formatter = new PlaneAngleFormatter(PlaneAngleFormatter::TEMPLATE_DDDMMSSs_DOTS); 
echo $angle->format($formatter); // 085.38.10.261

// where is 085 - integer degrees, 38 - integer minutes, 10.261 - seconds
```

### Latitude formatting

For latitude and longitude used delimiter template from `PlaneAngle` and added flag about sign-symbol position (leading or ending)

For `TEMPLATE_DDMMSS_SIGNS` and `TEMPLATE_DDMMSS_SPACES` degrees part will have 2 symbols always (add leading zero, for example 01 instead 1)

For `TEMPLATE_DDDMMSSs_DOTS` degrees part will have 3 symbols always (add leading zero, for example 071 instead 71)

```php
<?php

use PHP2GIS\Angle\Latitude;
use PHP2GIS\Angle\Formatter\LatitudeFormatter;

$lat = new Latitude(-21.937607457832);
$formatter = new LatitudeFormatter(
    LatitudeFormatter::TEMPLATE_DDMMSS_SIGNS, LatitudeFormatter::SYMBOL_LEADING
);
echo $lat->format($formatter); // S21°56′15″

$lat = new Latitude(70.758686634134);
$formatter = new LatitudeFormatter(
    LatitudeFormatter::TEMPLATE_DDDMMSSs_DOTS, LatitudeFormatter::SYMBOL_LEADING
); 
echo $lat->format($formatter); // N070.45.31.272

$lat = new Latitude(14.399535201676);
$formatter = new LatitudeFormatter(
    LatitudeFormatter::TEMPLATE_DDMMSS_SPACES, LatitudeFormatter::SYMBOL_ENDING
);
echo $lat->format($formatter); // 14 23 58N
```

### Longitude formatting

Longitude formatter in general is the same like latitude formatter, but degrees part will have 3 symbols always (adding leading zeros), and using `E` and `W` symbols for positive and negative values.
