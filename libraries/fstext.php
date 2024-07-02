<?php 
	class FSText
	{
		function __construct()
		{
		}
		public static function _($string)
		{
			global $translate;
			if(isset($translate[$string]))
				return $translate[$string];
			return $string;
		}
		
		/*
		 * load language
		 * position: 'backend' or 'fontend'
		 */
		public static function load_languages($position, $lang = 'en', $module = ''){
			$where = '';
			$field = 'lang_'.$lang;
			if($position == 'backend')
				$table_text_lang = 'fs_languages_text_admin';
			else 
				$table_text_lang = 'fs_languages_text';
				
			if($module)
				$where .= " OR module = '$module' ";

			// $query = " SELECT lang_key, ".$field." 
			// 			FROM ".$table_text_lang." 
			// 			WHERE is_common = 1
			// 		". $where;	
			// global $db;
			// $db -> query($query);
			// $list = $db->getObjectList();
			if($position != 'backend'){
				if(USE_MEMCACHE){
					$fsmemcache = FSFactory::getClass('fsmemcache');
					$mem_key = 'fstext_load_languages';
					
					$load_languages_memcache = $fsmemcache -> get($mem_key);
					
					if($load_languages_memcache){
						$list =  $load_languages_memcache;
					}else{
						global $db;
						$sql = "  SELECT lang_key, ".$field." 
							FROM ".$table_text_lang." 
				 			WHERE is_common = 1 
							". $where;	
						// $db->query($sql);
						$list =  $db->getObjectList($sql,USE_MEMCACHE);
						$blocks_in_memcache = $fsmemcache -> set($mem_key,$list,1000);
					}
				}else{
					global $db;
					$query = " SELECT lang_key, ".$field." 
							FROM ".$table_text_lang." 
				 			WHERE is_common = 1 
							". $where;	
					$db->query ( $query );
					$list = $db->getObjectList ();
				}
			}else{
				global $db;
					$query = " SELECT lang_key, ".$field." 
							FROM ".$table_text_lang." 
				 			WHERE is_common = 1 
							". $where;	
					$db->query ( $query );
					$list = $db->getObjectList ();
			}
			$arr_lang = array();
			for($i  = 0; $i < count($list); $i ++ ){
				$item  = $list[$i];
				$arr_lang[$item -> lang_key] = $item -> $field;
			}
			return $arr_lang;
		}
	}
?>