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

use \prggmr as pgr;

/**
 * Hosts
 *
 * Reading, adds and modifies the /etc/hosts file.
 */
class Hosts extends pgr\Singleton {
    
    const PSGMR_EDIT = "psgmr-hosts";
    
    /**
     * Current host configurations
     *
     * @var array
     */
    protected $_hosts = array();
    
    /**
     * constructor
     *
     * Reads the host file.
     */
    public function __construct()
    {
        $current = file_get_contents('/etc/hosts');
        // backup before we do anything
        file_put_contents('/tmp/'.self::PSGMR_EDIT, $current);
        $sys = array();
        $current = explode("\n", $current);
        foreach ($current as $_line) {
            $data = explode("\t", $_line);
            // unreadbale append to the end
            if (count($data) == 1) {
                $sys[] = $data[0];
            } else {
                // allow aliases
                $ip = $data[0];
                $name = $data[1];
                array_shift($data);
                array_shift($data);
                $this->_hosts[] = array(
                    'ip' => $ip,
                    'name' => $name,
                    'aliases' => $data
                );
            }
        }
        $this->_hosts[] = self::PSGMR_EDIT;
        $this->_hosts = array_merge($this->_hosts, $sys);
    }
    
    
    /**
     * Checks if the given host exists.
     *
     * @param  string  $host  Hostname
     * @param  string  $ip  Ip Address to use. Defaults to 127.0.1.1
     *
     * @return  boolean
     */
    public function has($host, $ip = '127.0.1.1')
    {
        foreach ($this->_hosts as $conf) {
            if (is_array($conf)) {
                if ($ip == $conf['ip'] && ($conf['name'] == $host || in_array($host, $conf['aliases']))) {
                   return true;
                }
            } elseif ($conf == self::PSGMR_EDIT) {
                break;
            } else {
                // shouldnt be here
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * Prepares a new host insert
     *
     * @param  string  $host  Hostname
     * @param  string  $ip  Ip Address
     */
    public function add($host, $ip = '127.0.1.1')
    {
        if (!$this->has($host, $ip)) {
            array_unshift($this->_hosts, array('name'=>$host,'ip'=>$ip,'aliases'=>array()));
            return true;
        }
        
        return false;
    }
    
    /**
     * Writes out the host file.
     *
     * @return  void
     */
    public function write(/* ... */)
    {
        $string = "";
        foreach ($this->_hosts as $conf) {
            if(is_array($conf)) {
                $string .= sprintf("%s\t%s\t%s\n", $conf['ip'], $conf['name'], implode('\t', $conf['aliases']));
            } elseif ($conf == self::PSGMR_EDIT) {
                continue;
            } else {
                $string .= $conf."\n";
            }
        }
        
        if ("" !== $string) {
            file_put_contents('/etc/hosts', $string);
        }
    }
}