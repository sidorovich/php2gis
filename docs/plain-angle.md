### Plain angle

```php
<?php

use PHP2GIS\Angle\PlaneAngle;

// create angle from degrees value
$angle = new PlaneAngle(90);

// create angle from radians value
$angle = new PlaneAngle(M_PI, true);

// create angle from degrees, minutes and seconds
$angle = new PlaneAngle();
$angle->setDegrees(90)
    ->setMinutes(1)
    ->setSeconds(20);
    
// for set degrees in format DD.dddd
$angle->setFloatValue(90.125);

// for compare angles with precision use method isEqual
$angle = new PlaneAngle(54.12345678);
$angle->isEqual($angle);                       // true
$angle->isEqual(new PlaneAngle(54.12345678)); // true
$angle->isEqual(new PlaneAngle(54.123456789)); // false

// radian values
$angle->setFloatValue(180);
echo $angle->getRadians(); // 3.14159265 M_PI
$angle->setRadians(M_PI);
echo $angle->getFloatValue(); // 180

// valid values for plain angle [0..360] degrees
// if you try to create angle with another value 
// you got PHP2GIS\Exception\InvalidArgumentException
```

I store degrees, minutes and seconds as different variables, and recalculate float degrees value on any change.
It's more faster for my usage, but it slowly for construct objects from degrees, minutes and seconds.
You can make it faster, just recalculate float value after changing last parameter.
For more details check method `refreshFloatValue` in class [PHP2GIS\Angle\AbstractAngle](../src/PHP2GIS/Angle/AbstractAngle.php)

```php
<?php

use PHP2GIS\Angle\PlaneAngle;
$angle->setDegrees(90, false) // not calculate after setting
    ->setMinutes(1, false)    // not calculate after setting
    ->setSeconds(20);         // recalculate all now
```
