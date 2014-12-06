<?php

/**
 * Bootstrap for unit-tests
 *
 * @since   2014-12-06
 * @author  Pavel Sidorovich <p.sidorovich@gmail.com>
 * @license MIT
 */

require_once (__DIR__ . '/../vendor/autoload.php');
require_once (__DIR__ . '/randomFactories.php');

defined('ASSERT_FLOAT_PRECISION') or define('ASSERT_FLOAT_PRECISION', 1e-3);
