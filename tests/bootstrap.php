<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author Daniel Schröder <daniel.schroeder@evolver.de>
 */

/**
 * Files will be created as -rw-rw-r--
 * Directories will be created as drwxrwxr-x
 */
umask(0002);

/**
 * Make everything relative to the application root
 */
chdir(dirname(__DIR__));

/**
 * Initialize autoloader
 */
require 'vendor/autoload.php';
