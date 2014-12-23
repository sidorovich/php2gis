[![Build Status](https://travis-ci.org/sidorovich/php2gis.svg?branch=plane-angle)](https://travis-ci.org/sidorovich/php2gis)

PHP2GIS
=======

Library for working with geodetic objects on Earth ellipsoid models. I write it for own using in aviation and simulator needs.

Supported ellipsoids:
- [WGS-84](https://en.wikipedia.org/wiki/World_Geodetic_System)
- [GRS-80](https://en.wikipedia.org/wiki/World_Geodetic_System)
- [PZ-90](https://ru.wikipedia.org/wiki/%D0%9F%D0%97-90)
- [SK-42](https://en.wikipedia.org/wiki/SK-42_reference_system)

If you need more simple library without latitude and longitude objects - try [mjaschen/phpgeo](https://github.com/mjaschen/phpgeo)

If you need more ellipsoid datums, and more conversions - try [MarkBaker/PHPGeodetic](https://github.com/MarkBaker/PHPGeodetic)
    
## Installation
    
Using [Composer](https://getcomposer.org), just add it to your `composer.json` by running:

```
composer require sidorovich/php2gis
```

## Usage

- [Plain angle](docs/plain-angle.md)
- [Latitude](docs/latitude.md)
- [Longitude](docs/longitude.md)
- [Angle formatting](docs/angle-formatting.md)
- [GeoPoint](docs/geopoint.md)

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
