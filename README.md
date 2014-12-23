[![Build Status](https://travis-ci.org/sidorovich/php2gis.svg?branch=plane-angle)](https://travis-ci.org/sidorovich/php2gis)

PHP2GIS
=======

Simple library for working with geodetic objects on Earth ellipsoid models

Supported ellipsoids:
- [WGS-84](https://en.wikipedia.org/wiki/World_Geodetic_System)
- [GRS-80](https://en.wikipedia.org/wiki/World_Geodetic_System)
- [PZ-90](https://ru.wikipedia.org/wiki/%D0%9F%D0%97-90)
- [SK-42](https://en.wikipedia.org/wiki/SK-42_reference_system)
    
## Installation
    
Using [Composer](https://getcomposer.org), just add it to your `composer.json` by running:

```
composer require sidorovich/php2gis
```

## Usage

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
$angle->isEqual(new PlaneAngle(54.123456789)); // true
$angle->isEqual(new PlaneAngle(54.123456789)); // false

// radian values
$angle->setFloatValue(180);
echo $angle->getRadians(); // 3.14159265 M_PI
$angle->setRadians(M_PI);
echo $angle->getFloatValue(); // 180

// valid values for plain angle [0..360] degrees
// if you try to create angle with another value - you got PHP2GIS\Exception\InvalidArgumentException
```

I store degrees, minutes and seconds as different variables, and recalculate float degrees value on any change.
It's more faster for my usage, but it slowly for construct objects from degrees, minutes and seconds.
You can make it faster, just recalculate float value after last changing parameter.

```php
<?php

use PHP2GIS\Angle\PlaneAngle;
$angle->setDegrees(90, false) // after setting degrees object no calculate float value
    ->setMinutes(1, false)    // after setting minutes object no calculate float value too
    ->setSeconds(20);         // but now all will be calculated and you get correct value by method getFloatValue
```

## License

Copyright (c) 2014 Pavel Sidorovich <p.sidorovich@gmail.com>

MIT License

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
