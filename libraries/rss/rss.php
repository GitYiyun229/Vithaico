<?php

class RSS
{
	public function RSS()
	{
	}
	
	public function GetFeed()
	{
		return $this->getDetails() . $this->getItems();
	}
	
	
	private function getDetails2()
	{
		$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				<rss version="2.0">
					<channel>

           <title>Tin tuc</title>
			<link>'."http://localhost/svn/designs/SourceCode/index.php?module=news/view=news/id=2/Itemid=9".'</link>
           <description>Natural Vibrations.</description>
           <language>en-us</language>
           <pubDate>Tue, 10 Jun 2003 04:00:00 GMT</pubDate>
           <lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>
           <docs>http://blogs.law.harvard.edu/tech/rss</docs>
           <generator>Weblog Editor 2.0</generator>
           <managingEditor>editor@example.com</managingEditor>
           <webMaster>webmaster@example.com</webMaster>';
		return $details;
	}
	
	private function getDetails()
	{
		$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				<rss version="2.0">
					<channel>
						<title>'. 'Digiworld'.'</title>
						<link>'. URL_ROOT.'</link>
						<description>'.'Digiworld'.'</description>
						<language>'. 'vi' .'</language>
						<image>
							<title>'. URL_ROOT .'</title>
							<url>'. URL_ROOT.'images/config/logo.png' .'</url>
							<link>'. URL_ROOT .'</link>
							<width>'. 245 .'</width>
							<height>'. 96 .'</height>
						</image>';
		return $details;
	}
	
	private function getItems()
	{
		global $db;
		
		$query = "SELECT *
				FROM fs_products
				WHERE published = 1
				ORDER BY ID DESC
				LIMIT 0,40
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=products&view=product&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$image_small = str_replace('/original/', '/resized/', $row->image);
			$xml .= '<item>
						 <title>'. $row->name .'</title>
						 <link>'. $link.'</link>
						 <description><![CDATA['.'<a href = "'.$link.'" >
						<a href="'. $link.'" title="'.$row->title.'" width="126" height="197">
							<img alt="'.$row->title.'" src="'.$image_small.'" width="126" height="197"/>
						</a>' 
						.']]></description>
						 <pubDate>'.date('d/m/Y H:i',strtotime($row->created_time)).'</pubDate>
					 </item>';
		}
		
		$xml .= '</channel>
				 </rss>';
		return $xml;
	}

}

?>