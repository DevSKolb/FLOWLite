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
class SecurityStorage extends System
{
    /**
     * filter
     *
     * @var   object instance of filter object
     */
	private $filter;

    /**
     * filters
     *
     * @var   array
     */
	private $filters;

    /**
     * xml file with filters
     *
     * @var   string
     */
	private $source = '';

    /**
     * Filter container
     *
     * @var array
     */
    protected $filterSet = array();

    /**
     * Adds a filter
     *
     * @param object $filter IDS_Filter instance
     * 
     * @return object $this
     */
    public final function addFilter($filter) 
    {
        $this->filterSet[] = $filter;
        return $this;
    }
    
    /**
     * Returns registered filters
     *
     * @return array
     */
    public final function getFilterSet() 
    {
        return $this->filterSet;
    }

    /**
     * Constructor
     *
     * Instance of SecurityManager
     * @return void
     */
	public function __construct(){

		parent::__construct();

        // xml file with filters
		$this->source = $_SERVER["DOCUMENT_ROOT"] .'/'. $this->registry->securityFile;   		
  	}

    /**
     * Loads filters from XML using SimpleXML
     *
     * This function parses the provided source file and stores the result. 
     *
     * @throws Exception if problems with fetching the XML data occur
     * @return object $this
     */
    public function getFilterFromXML() 
    {
        if (extension_loaded('SimpleXML')) {

            /*
             * If they aren't, parse the source file
             */
            if (file_exists($this->source)) {
                    if (LIBXML_VERSION >= 20621) {
                        $filters = simplexml_load_file($this->source,
                                                       null,
                                                       LIBXML_COMPACT);
                    } else {
                        $filters = simplexml_load_file($this->source);
                    }
            }
            else
                throw new Exception(
                    '['.$this->source.'] XML file not found.', 405
                );
            
            
            /*
             * In case we still don't have any filters loaded and exception
             * will be thrown
             */
            if (empty($filters)) {
                throw new Exception(
                    'XML data could not be loaded.' . 
                        ' Make sure you specified the correct path.', 412
                );
            }

            /*
             * Now the storage will be filled with IDS_Filter objects
             */
            $data    = array();

            foreach ($filters as $filter) {

                $rule        = $filter->rule;
                $impact      = $filter->impact;                
                $description = $filter->description;

                $this->addFilter(new SecurityFilter( $rule,  $description,	(int) $impact));
            }


        } else {
            throw new Exception(
                'SimpleXML not loaded.'
            );
        }
        return $this;
	}


}
?>