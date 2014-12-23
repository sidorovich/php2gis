<?php

namespace PHP2GIS\Angle;

use PHP2GIS\Angle\Formatter\AngleFormatterInterface;

/**
 * Class AbstractAngle
 *
 * @package PHP2GIS\Angle
 * @since   2014-10-23
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */
abstract class AbstractAngle
{
    const EPS = 1e-9;

    /**
     * The integer part of degrees of angle
     *
     * @var int
     */
    protected $degrees;

    /**
     * The integer part of minutes of angle
     *
     * @var int
     */
    protected $minutes;

    /**
     * Seconds of angle
     *
     * @var float
     */
    protected $seconds;

    /**
     * Float value of angle with degrees, second and minutes
     *
     * @var float
     */
    protected $floatValue;

    /**
     * Construct angle
     *
     * @param float|string|bool $angle
     * @param bool              $isRadiansValue
     */
    public function __construct($angle = false, $isRadiansValue = false)
    {
        if (false !== $angle) {
            if (is_numeric($angle)) {
                if ($isRadiansValue) {
                    $this->setRadians(doubleval($angle));
                } else {
                    $this->setFloatValue(doubleval($angle));
                }
            }
        }
    }

    /**
     * Set float angle value
     *
     * @param float $value
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFloatValue($value)
    {
        $this->validateFloatValue($value);
        $this->setDegrees((int)($value), false);
        $value = abs($value);
        $this->setMinutes((int)(($value - abs($this->degrees)) * 60), false);
        $this->setSeconds(((($value - abs($this->degrees)) * 60) - $this->minutes) * 60, false);
        $this->refreshFloatValue();
        return $this;
    }

    /**
     * @return float
     */
    public function getFloatValue()
    {
        return $this->floatValue;
    }

    /**
     * @param int $degrees
     * @param bool $isRefreshFloatValue
     * @return $this
     */
    public function setDegrees($degrees, $isRefreshFloatValue = true)
    {
        $this->degrees = $degrees;
        if ($isRefreshFloatValue) {
            $this->refreshFloatValue();
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getDegrees()
    {
        return $this->degrees;
    }

    /**
     * @param int $minutes
     * @param bool $isRefreshFloatValue
     * @return $this
     */
    public function setMinutes($minutes, $isRefreshFloatValue = true)
    {
        $this->minutes = $minutes;
        if ($isRefreshFloatValue) {
            $this->refreshFloatValue();
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * @param float $seconds
     * @param bool $isRefreshFloatValue
     * @return $this
     */
    public function setSeconds($seconds, $isRefreshFloatValue = true)
    {
        $this->seconds = $seconds;
        if ($isRefreshFloatValue) {
            $this->refreshFloatValue();
        }
        return $this;
    }

    /**
     * @return float
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param AbstractAngle $angle
     * @return bool
     */
    public function isEqual(AbstractAngle $angle)
    {
        return (get_class($this) == get_class($angle))
            && (abs($this->getFloatValue() - $angle->getFloatValue()) < static::EPS);
    }

    /**
     * Format current angle value
     *
     * @param AngleFormatterInterface $formatter
     * @return mixed
     */
    public function format(AngleFormatterInterface $formatter)
    {
        return $formatter->format($this);
    }

    /**
     * Get radians value of angle
     *
     * @return float
     */
    public function getRadians()
    {
        return $this->floatValue * M_PI / 180;
    }

    /**
     * @param float $radianAngle
     * @return AbstractAngle
     */
    public function setRadians($radianAngle)
    {
        return $this->setFloatValue(doubleval($radianAngle) * 180 / M_PI);
    }

    /**
     * Refresh float value of angle
     *
     * @return $this
     */
    protected function refreshFloatValue()
    {
        $this->floatValue = abs($this->degrees) + ($this->minutes / 60) + ($this->seconds / 3600);
        if ($this->degrees < 0) {
            $this->floatValue = -abs($this->floatValue);
        };
        return $this;
    }

    /**
     * Validate float value of angle before set
     *
     * @param float $value
     * @return void
     * @throws \InvalidArgumentException
     */
    abstract protected function validateFloatValue($value);

}
