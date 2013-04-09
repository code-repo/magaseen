<?php
//
//  Pear DB Pager - Retrieve and return information of databases
//                  result sets
//
//  Copyright (C) 2001  Tomas Von Veschler Cox <cox@idecnet.com>
//
//  This library is free software; you can redistribute it and/or
//  modify it under the terms of the GNU Lesser General Public
//  License as published by the Free Software Foundation; either
//  version 2.1 of the License, or (at your option) any later version.
//
//  This library is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//  Lesser General Public License for more details.
//
//  You should have received a copy of the GNU Lesser General Public
//  License along with this library; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
//
//
// $Id: Pager.php,v 1.3 2002/05/12 13:59:40 cox Exp $

require_once 'PEAR.php';
require_once 'DB.php';

/**
* This class handles all the stuff needed for displaying paginated results
* from a database query of Pear DB, in a very easy way.
* Documentation and examples of use, can be found in:
* http://vulcanonet.com/soft/pager/ (could be outdated)
*
* IMPORTANT!
* Since PEAR DB already support native row limit (more fast and avaible in
* all the drivers), there is no more need to use $pager->build() or
* the $pager->fetch*() methods.
*
* Usage example:
*
*< ?php
* require_once 'DB/Pager.php';
* $db = DB::connect('your DSN string');
* $from = 0;   // The row to start to fetch from (you might want to get this
*              // param from the $_GET array
* $limit = 10; // The number of results per page
* $maxpages = 10; // The number of pages for displaying in the pager (optional)
* $res = $db->limitQuery($sql, $from, $limit);
* $nrows = 0; // Alternative you could use $res->numRows()
* while ($row = $res->fetchrow()) {
*    // XXX code for building the page here
*     $nrows++;
* }
* $data = DB_Pager::getData($from, $limit, $nrows, $maxpages);
* // XXX code for building the pager here
* ? >
*
* @version 0.7
* @author Tomas V.V.Cox <cox@idecnet.com>
* @see http://vulcanonet.com/soft/pager/
*/
// Added By RPK on 060119
require_once(LIBRARY_PATH.'smarty/libs/Smarty.class.php');	
// Added By RPK on 060119

class DB_Pager extends PEAR
{

    /**
    * Constructor
    *
    * @param object $res  A DB_result object from Pear_DB
    * @param int    $from  The row to start fetching
    * @param int    $limit  How many results per page
    * @param int    $numrows Pager will automatically
    *    find this param if is not given. If your Pear_DB backend extension
    *    doesn't support numrows(), you can manually calculate it
    *    and supply later to the constructor
    * @deprecated
    */
	// Added By RPK on 060119
	var $smarty;
	// Added By RPK on 060119
	
    // Added By RPK on 060119
	//function DB_Pager (&$res, $from, $limit, $stPageUrl, $numrows = null)
	function DB_Pager (&$res, $page, $limit, $stExtraParam, $numrows = null, $pagelimit = null)
	{
        $this->res = $res;
		$this->page = $page;
        $this->from = $limit * ($page-1);		
		
        $this->limit = $limit;
        $this->numrows = $numrows;
		$this->smarty = new Smarty(TEMPLATE_PATH);
		$arParsedUrl=array_reverse(explode("/",$PHP_SELF));				
		$this->smarty->assign('PAGINGURL',$arParsedUrl[0]);
		$this->smarty->assign('SITEURL', SITE_URL);
		$this->smarty->assign('SITEGRAPHICSPATH', ADMIN_GRAPHICS_URL);
		$this->smarty->assign('EXTRA_PARAM', $stExtraParam);
	}

    /**
    * Calculates all the data needed by Pager to work
    *
    * @return mixed An assoc array with all the data (see getData)
    *    or DB_Error on error
    * @see DB_Pager::getData
    * @deprecated
    */
    function build()
    {
        // if there is no numrows given, calculate it
        if ($this->numrows === null) {
            $this->numrows = $this->res->numrows();
            if (DB::isError($this->numrows)) {
                return $this->numrows;
            }
        }
		// Added By RPK on 060119
		if($this->from <0 || $this->from >= $this->numrows)
		{
			$this->from = 0;
		}
		// Added By RPK on 060119
        $data = $this->getData($this->from, $this->limit, $this->numrows,$this->page);
        if (DB::isError($data)) {
            return $data;
        }
        $this->current = $this->from - 1;
        $this->top = $data['to'];
		
		// Added By RPK on 060119		
		$this->smarty->assign('PREV_PAGE',$data['prevPage']);
		$this->smarty->assign('NEXT_PAGE',$data['nextPage']);
		$this->smarty->assign('FIRST_PAGE',$data['firstpage']);
		$this->smarty->assign('LAST_PAGE',$data['lastpage']);
		$this->smarty->assign('CURRENT_PAGE',$data['current']);
		$this->smarty->assign('ARR_PAGE',$data['page']);
		$this->smarty->assign('TOTAL_PAGE',count($data['page']));
		// Added By RPK on 060119
		
		// Added By RPK on 060523		    
	   // return $data;
		  $arPath= pathinfo($_SERVER['PHP_SELF']);
		  $numPages = count($data['page']);
		  $arPages = array();
		  $arPageValue = array();

		  if($arPath['basename'] == 'index.php')
		  {		  		  
			  for($i = 1; $i<$numPages+1; $i++)
			  { 								
					if($numPages == 1)
					{					
						break;
					}
					if($data['current'] <=5)
					{
						if($i<= $data['current']+2 || $i >= $numPages-2)
						{
							if($i == $data['current']+2)
							{
								$arPages[] = "..";
								$arPageValue[] = $i;
							}
							else
							{
								$arPages[] ="";
								$arPageValue[] = $i;
							}
						}					
						else
						{
							continue;
						}					
					}
					else if($data['current'] >= $numPages-4)
					{
						if($i >= $data['current']-2 || $i<= 3)
						{
							if($i == 3)
							{
								$arPages[] = "..";
								$arPageValue[] = $i;
							}
							else
							{
								$arPages[] = "";
								$arPageValue[] = $i;
							}
						}					
						else
						{
							continue;
						}					
					}
					else if(($data['current'] >5 && $data['current'] < $numPages-4))
					{
						if($i<= 3 || $i >= $numPages-2 || ($i >= $data['current']-2 && $i <= $data['current']+2))
						{
							if($i == 3 || $i == $data['current']+2)
							{
								$arPages[] = "..";
								$arPageValue[] = $i;
							}
							else
							{
								$arPages[] = "";
								$arPageValue[] = $i;
							}
						}					
						else
						{
							continue;
						}
					}																			
				}			
				//print_r($arPages);
				//exit();
				$this->smarty->assign('ARR_PAGES_VALUE',$arPageValue);
				$this->smarty->assign('ARR_PAGES',$arPages);
			   return $this->smarty->fetch('user_paging.tpl.html');
		  }
		  else
		  {
			   return $this->smarty->fetch('paging.tpl.html');
		  }
		  // Added By RPK on 060523
    }

    /**
    * @deprecated
    */
/*    function fetchRow($mode=DB_FETCHMODE_DEFAULT)
    {
        $this->current++;
        if ($this->current >= $this->top) {
            return null;
        }
        return $this->res->fetchRow($mode, $this->current);
    }

    /**
    * @deprecated
    */
    /*function fetchInto(&$arr, $mode=DB_FETCHMODE_DEFAULT)
    {
        $this->current++;
        if ($this->current >= $this->top) {
            return null;
        }
        return $this->res->fetchInto($arr, $mode, $this->current);
    }

    /*
    * Gets all the data needed to paginate results
    * This is an associative array with the following
    * values filled in:
    *
    * array(
    *    'current' => X,    // current page you are
    *    'numrows' => X,    // total number of results
    *    'next'    => X,    // row number where next page starts
    *    'prev'    => X,    // row number where prev page starts
    *    'remain'  => X,    // number of results remaning *in next page*
    *    'numpages'=> X,    // total number of pages
    *    'from'    => X,    // the row to start fetching
    *    'to'      => X,    // the row to stop fetching
    *    'limit'   => X,    // how many results per page
    *    'maxpages'   => X, // how many pages to show (google style)
    *    'firstpage'  => X, // the row number of the first page
    *    'lastpage'   => X, // the row number where the last page starts
    *    'pages'   => array(    // assoc with page "number => start row"
    *                1 => X,
    *                2 => X,
    *                3 => X
    *                )
    *    );
    * @param int $from    The row to start fetching
    * @param int $limit   How many results per page
    * @param int $numrows Number of results from query
    *
    * @return array associative array with data or DB_error on error
    *
    */
    function &getData($from, $limit, $numrows, $inpage, $maxpages = false)
    {
        if (empty($numrows) || ($numrows < 0)) {
            return null;
        }

        $from = (empty($from)) ? 0 : $from;

        if ($limit <= 0) {
            return PEAR::raiseError (null, 'wrong "limit" param', null,
                                     null, null, 'DB_Error', true);
        }


        // Total number of pages
        $pages = ceil($numrows/$limit);
		$pagelimit = 20;
		$start = 1;
		$end = $pages; 
		if( $pages>$pagelimit)
		{			
			$end = $start+20; 
			if($inpage>$pagelimit/2)
			{
				$start = $inpage - $pagelimit/2;
				$end = $inpage + $pagelimit/2;
			}
			if($end > $pages)
				$end = $pages; 
		}
        $data['numpages'] = $pages;

        // first & last page
        $data['firstpage'] = 1;
        $data['lastpage']  = $pages;

        // Build pages array
        $data['pages'] = array();
        for ($i=$start; $i <= $end; $i++) {
            $offset = $limit * ($i-1);
            $data['pages'][$i] = $offset;
            // $from must point to one page
            if ($from == $offset) {
                // The current page we are
                $data['current'] = $i;
            }
        }
        if (!isset($data['current'])) {
            return PEAR::raiseError (null, 'wrong "from" param', null,
                                     null, null, 'DB_Error', true);
        }

        // Limit number of pages (goole algoritm)
        if ($maxpages) {
            $radio = floor($maxpages/2);
            $minpage = $data['current'] - $radio;
            if ($minpage < 1) {
                $minpage = 1;
            }
            $maxpage = $data['current'] + $radio - 1;
            if ($maxpage > $data['numpages']) {
                $maxpage = $data['numpages'];
            }
            foreach (range($minpage, $maxpage) as $page) {
                $tmp[$page] = $data['pages'][$page];
            }
            $data['pages'] = $tmp;
            $data['maxpages'] = $maxpages;
        } else {
            $data['maxpages'] = null;
        }

        // Prev link
        $prev = $from - $limit;
        $data['prev'] = ($prev >= 0) ? $prev : null;
		
		// Added By RPK on 060119
		// Prev Page
        $prevPage = ($data['prev']/$limit) + 1;
        $data['prevPage'] = ($data['current'] != $data['firstpage']) ? $prevPage : null;		
		// Added By RPK on 060119

        // Next link
        $next = $from + $limit;
        $data['next'] = ($next < $numrows) ? $next : null;

		
		// Added By RPK on 060119
		// Last Page
        $nextPage = ($data['next']/$limit) + 1;
        $data['nextPage'] = ($data['current'] != $data['lastpage']) ? $nextPage : null;
		$data['page'] = array_keys($data['pages']);
		// Added By RPK on 060119

        // Results remaining in next page & Last row to fetch
        if ($data['current'] == $pages) {
            $data['remain'] = 0;
            $data['to'] = $numrows;
        } else {
            if ($data['current'] == ($pages - 1)) {
                $data['remain'] = $numrows - ($limit*($pages-1));
            } else {
                $data['remain'] = $limit;
            }
            $data['to'] = $data['current'] * $limit;
        }
        $data['numrows'] = $numrows;
        $data['from']    = $from + 1;
        $data['limit']   = $limit;
        return $data;
    }
}
?>
