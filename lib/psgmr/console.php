<?php
namespace psgmr;
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
 * @author  Nickolas Whiting <me@nwhiting.com>
 * @package  psgmr
 * @copyright  Copyright (c), 2010 Nickolas Whiting
 */

use prggmr as pgr;

/**
 * Console
 *
 * The console object handles all outputting and reciving console information
 */
class Console extends pgr\Singleton {
    
    public $lb = null;
    
    /**
     * construct
     *
     * Setup the line break ... nothing else required.
     */
    public function __construct(/* ... */)
    {
        if (!defined('LINE_BREAK')) {
            $this->lb = "\n";
        } else {
            $this->lb = LINE_BREAK;
        }
    }
    
    /**
     * Dumps a string to the console.
     *
     * @param  string  $string  String to output
     * @param  boolean  $lb  ouput a line ending line break
     *
     * @return  void
     */
    public function output($string, $lb = true)
    {
        fwrite(STDOUT, (!$lb) ? $string : $string.$this->lb);
    }

    /**
     * Provides a method to ask and receieve feedback via the console.
     *
     * The feedback generates the *console_feedback_title* event when received.
     *
     * @event  console_feedback_{title}
     * @param  string  $title  Title of feedback expected.
     * @param  string  $feedback  Question to ask.
     *
     * @return  void
     */
    public function feedback($feedback, $title)
    {
        $this->output($feedback . " ", false);
        $input = trim(fgets(STDIN));
        fire("psgmr.feedback.$title", array($input));
        return true;
    }
}