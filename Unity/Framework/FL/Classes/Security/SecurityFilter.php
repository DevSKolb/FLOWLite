<?php
/*                                                                        *
 * This script belongs to the FLOWLite framework.                         *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        */
/**
 *
 * Each object of this class serves as a container for a specific filter. The 
 * object provides methods to get information about this particular filter and 
 * also to match an arbitrary string against it.
 *
 * @category  Security
 * @package   PHPIDS
 * @author    Lars Strojny <lars@strojny.net>
 * @copyright 2007-2009 The PHPIDS Group
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL
 * @version   Release: $Id:Filter.php 517 2007-09-15 15:04:13Z mario $
 * @link      http://php-ids.org/
 */
class SecurityFilter
{

    /**
     * Filter rule
     *
     * @var    string
     */
    protected $rule;

    /**
     * Filter impact level
     *
     * @var    integer
     */
    protected $impact = 0;

    /**
     * Filter description
     *
     * @var    string
     */
    protected $description = null;

    /**
     * Constructor
     *
     * @param integer $id          filter id
     * @param mixed   $rule        filter rule
     * @param string  $description filter description
     * @param array   $tags        list of tags
     * @param integer $impact      filter impact level
     * 
     * @return void
     */
    public function __construct($rule, $description, $impact) 
    {
        $this->rule        = $rule;
        $this->impact      = $impact;
        $this->description = $description;
    }

    /**
     * Matches a string against current filter
     *
     * Matches given string against the filter rule the specific object of this
     * class represents
     *
     * @param string $string the string to match
     * 
     * @throws InvalidArgumentException if argument is no string
     * @return boolean
     */
    public function match($string)
    {
		if ($string == NULL) return false;

        if (!is_string($string)) {
            throw new Exception('Invalid argument. Expected a string, received ' . gettype($string)
            );
        }

        return (bool) preg_match(
            '/' . $this->getRule() . '/ms', strtolower($string)
        );
    }

    /**
     * Returns filter description
     *
     * @return string
     */
    public function getDescription() 
    {
        return $this->description;
    }

    /**
     * Return list of affected tags
     *
     * Each filter rule is concerned with a certain kind of attack vectors. 
     * This method returns those affected kinds.
     *
     * @return array
     */
    public function getTags() 
    {
        return $this->tags;
    }

    /**
     * Returns filter rule
     *
     * @return string
     */
    public function getRule() 
    {
        return $this->rule;
    }

    /**
     * Get filter impact level
     *
     * @return integer
     */
    public function getImpact() 
    {
        return $this->impact;
    }

}