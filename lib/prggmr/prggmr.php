<?php
/**
 *  Copyright 2010 Nickolas Whiting
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 *
 * @author  Nickolas Whiting  <me@nwhiting.com>
 * @package  prggmr
 * @copyright  Copyright (c), 2010 Nickolas Whiting
 */

define('PRGGMR_VERSION', '0.2.0');

// start'er up
require 'functions.php';
require 'data.php';
require 'singleton.php';
require 'engine.php';
require 'signalinterface.php';
require 'signal.php';
require 'regexsignal.php';
require 'adapterinterface.php';
require 'adapter.php';
require 'event.php';
require 'api.php';
require 'benchmark.php';
require 'queue.php';
require 'subscription.php';