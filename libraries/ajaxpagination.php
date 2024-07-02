<?php
/*
 * Huy write
 */

class AjaxPagination
{
	var $limit;
	var $total;
	
	function __construct($limit,$total){
		$this->$limit  = $limit;
		$this->total = $total;
		$this->pages =ceil($this->total /$this->$limit) ;	
	}
	
	/*
	 * maxpage is max page is show. But It is not last pageg.
	 * ex: 1,2,3,4..100.=> 4 is max page 
	 */
	function showPagination()
	{
		$html = '';
		//create pagination
		if($this->pages > 1)
		{
			$html .= '<ul class="paginate">';
			for($i = 1; $i<=$this->pages; $i++)
			{
				$html .= '<li><a href="#" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
			}
			$html .= '</ul>';
		}
		return $html;
	}
}