<?php
/*
 * Huy write
 */

class Pagination
{
	var $limit;
	var $total;
	var $page;
	var $url;
	
	function __construct($limit,$total,$page,$url = ''){
		$this->limit = $limit;
		$this->total = $total;
		$this->page = $page;
			if($url)
				$this->url = $url;
			else
			{
				$url = $_SERVER['REQUEST_URI'];
				$this->url = $url;
			}
	
	}
	

	function create_link_with_page($url, $page)
    {
        if (!IS_REWRITE) {
            $url = trim(preg_replace('/&page=[0-9]+/i', '', $url));
            if (!$page || $page == 1) {
                return $url;
            } else {
                return $url . '&page=' . $page;
            }
        } else {
            if (strpos($url, '.html') !== false) {
                if (!$page || $page == 1) {
                    $url = trim(preg_replace('/\/page-[0-9]+/i', '', $url));
                } else {
                    $search = preg_match('#\/page-([0-9]+)#is', $url, $main);
                    if ($search) {
                        $url = preg_replace('/\/page-[0-9]+/i', '/page-' . $page, $url);
                    } else {
                        $url = preg_replace('/.html/i', '/page-' . $page . '.html', $url);
                    }
                }
            } else {
                $url = trim(preg_replace('/\/page-[0-9]+/i', '', $url));

                $qString = '';
                $arr_url[] = $url;
                if (strpos($url, '?') !== false) {
                    $arr_url = explode('?', $url);
                    $qString = $arr_url[1];
                }

                $url = $arr_url[0];
                if (!$page || $page == 1) {
                    $url = $url;
                } else {
                    $url = $url . '/page-' . $page;
                }
                $qString = $qString ? '?' . $qString : '';
                $url = $url . $qString;

            }
            $rUrl = $_SERVER['REQUEST_URI'];
            $rUri = $_SERVER['REQUEST_URI'];
            $qString = "";
            if (strlen($rUri) > strlen($rUrl)) {
                $qString = substr($rUri, strlen($rUrl), strlen($rUri) - strlen($rUrl));
            }
            return $url . $qString;
        }
    }
	
	function create_link_with_page_ajax($url,$page){
		
		$url =  trim(preg_replace('/&page=[0-9]+/i', '', $url));
		
		if(!$page || $page == 1){
			return $url;
		} else {
			return $url.'&page='.$page;
		}
	}
	
	/*
	 * maxpage is max page is show. But It is not last pageg.
	 * ex: 1,2,3,4..100.=> 4 is max page 
	 */
	function showPagination($maxpage = 5)
	{
		$previous = "<span><</span>";
		$next = "<span>></span>";
		$first_page = "<<";
		$last_page = ">>";
		
		$current_page = FSInput::get('page');
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			$start_page = $current_page - $maxpage;
			if($start_page <= 0)
				 $start_page = 1;
			
			$end_page = $current_page + $maxpage;
			
			if($end_page > $num_of_page) 
				$end_page = $num_of_page;
			
			//WRITE prefix on screen
			$html  .= "<div class='pagination'>";
			//$html .=  "<font class='title_pagination'>" . FSText :: _('') . "</font> ";
			//Write Previous
			if(($current_page > 1) && ($num_of_page > 1)){
				$html .= "<a class='first-page' title='first_page' href='" . Pagination::create_link_with_page($this->url,0) . "' title='".FSText::_('First page')."' >" . $first_page . "</a>";
				$html .= "<a class='pre-page' title='pre_page' href='" . Pagination::create_link_with_page($this->url,$current_page-1). "' title='".FSText::_('Previous')."' >" . $previous . "</a>";
				if($start_page !=1)
					 $html .= "<b>...</b>";
			}
			for($i=$start_page; $i<=$end_page; $i++){
				if($i != $current_page){
					if($i == 1)
					 	$html .= "<a class='other-page' title='Page " . $i . "' href='" . Pagination::create_link_with_page($this->url,0) . "' ><span>" . $i . "</span></a>";
					else
                        $html .= "<a class='other-page' title='Pages " . $i . "' href='" . Pagination::create_link_with_page($this->url,$i) . "' ><span>" . $i . "</span></a>";
					
				}
				else{
					//  $html .= "<font title='Page " . $i . "' class='current'>" . $i . "</font>";
					$html .= "<font title='Page " . $i . "' class='current'><span>" . $i . "</span></font>";
				}
			}
			//Write Next
			if(($current_page < $num_of_page) && ($num_of_page > 1)){
				if($end_page < $num_of_page) 
					$html .= "<b>...</b>";
				$html .= "<a class='next-page' title='Next page' href='" . Pagination::create_link_with_page($this->url,$current_page+1) . "' >" . $next . "</a>";
				$html .= "<a class='last-page' title='Last page' href='" . Pagination::create_link_with_page($this->url,$num_of_page). "' >" . $last_page . "</a>";
			}
			$html .= "</div>";
		}
		
		return $html;
	}
}