<?php

class SITEMAP
{
	public function GetFeed()
	{
		return $this->getDetails(). $this-> getItems_news_cat() . $this-> getItems_news() . $this->getItems_products_cat(). $this->getItems_products() . $this-> getItems_contents() ;
	}
	
	
	private function getDetails()
	{
		$details = '
                    <url>
                      <loc>'.URL_ROOT.'</loc>
                      <lastmod>2021-11-11</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>1</priority>
                    </url>
                    <url>
                      <loc>'.URL_ROOT.'tin-tuc</loc>
                      <lastmod>2021-11-11</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.8</priority>
                    </url>
                    <url>
                      <loc>'.URL_ROOT.'lien-he</loc>
                      <lastmod>2021-11-11</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.5</priority>
                    </url>                
                    <url>
                      <loc>'.URL_ROOT.'he-thong-cua-hang</loc>
                      <lastmod>2021-11-11</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.5</priority>
                    </url> 
                    ';
		return $details;
	}

	private function getItems_news()
	{
		global $db;
		
		$query = " SELECT id,title,alias,created_time,updated_time,category_alias,image
				FROM fs_news
				WHERE published = 1
				ORDER BY created_time DESC
				";
		//$db->query($query);
		$result = $db->getObjectList($query);
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=news&view=news&ccode=".$row->alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.8</priority>                        
                        </url>  
                    ';
		}

		return $xml;
	}
    
    private function getItems_news_cat()
	{
		global $db;
		
		$query = " SELECT id,name,alias,created_time,updated_time
				FROM fs_news_categories
				WHERE published = 1
				ORDER BY created_time DESC
				";
		//$db->query($query);
		$result = $db->getObjectList($query);
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_('index.php?module=news&view=cat&ccode='.$row->alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.8</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
     private function getItems_contents()
	{
		global $db;
		
		$query = "SELECT id,title,alias,created_time,updated_time,category_alias
				FROM fs_contents
				WHERE published = 1
				ORDER BY created_time DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
            $link = FSRoute::_("index.php?module=contents&view=contents&ccode=".$row->alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.5</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
   private function getItems_video()
	{
		global $db;
		
		$query = "SELECT *
				FROM fs_video
				WHERE published = 1
				ORDER BY ID DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
       
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
           $link = FSRoute::_("index.php?module=videos&view=video&id=".$row->id."&code=".$row->alias);
			$xml .= '
                     <url>
                         <loc>'.$link.'</loc>
                         <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                         <changefreq>daily</changefreq>
                         <priority>0.6</priority>
                       </url>  
                   ';
		}

		return $xml;
	}
      
    
	private function getItems_products()
	{
		global $db;
		
		$query = "SELECT id,name,alias,created_time,edited_time,category_alias
				FROM fs_products
				WHERE published = 1 AND status_prd < 4 
				ORDER BY created_time DESC
				
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_('index.php?module=products&view=product&ccode='.$row -> alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->edited_time)).'</lastmod>
                          <changefreq>weekly</changefreq>
                          <priority>0.9</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
    private function getItems_products_cat()
	{
		global $db;
		
		$query = " SELECT id,name,alias,created_time,updated_time
				FROM fs_products_categories
				WHERE published = 1
				ORDER BY ID DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
       
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
           $link = FSRoute::_('index.php?module=products&view=cat&ccode='.$row->alias);
			$xml .= '
                     <url>
                         <loc>'.$link.'</loc>
                         <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                         <changefreq>daily</changefreq>
                         <priority>0.9</priority>
                       </url>  
                   ';
		}

		return $xml;
	}

}

?>