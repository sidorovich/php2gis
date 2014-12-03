<?php

namespace PHP2GIS\Angle;

/**
 * Interface AngleFormatterInterface
 *
 * @package PHP2GIS\Angle
 * @since   2014-10-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
interface AngleFormatterInterface
{
    /**
     * Main method for formatting angle
     *
     * @param AbstractAngle $angle
     * @return mixed
     */
    public function formatAngle(AbstractAngle $angle);
}
