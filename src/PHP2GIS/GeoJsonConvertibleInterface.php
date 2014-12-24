<?php

namespace PHP2GIS;

/**
 * Interface GeoJsonConvertibleInterface
 *
 * @package PHP2GIS
 * @since   2014-12-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
interface GeoJsonConvertibleInterface
{
    /**
     * Return associative array for encode to GeoJSON format
     *
     * @return array
     */
    public function toGeoJson();
}
