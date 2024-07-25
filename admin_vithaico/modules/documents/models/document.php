<?php

class DocumentsModelsDocument extends FSModels {

    var $limit;
    var $prefix;

    function __construct() {
        $this->limit = 20;
        $this->view = 'document';
        $this->table_name = FSTable_ad::_('fs_documents');
        $this -> table_category_name = FSTable_ad::_('fs_documents_categories');
        $this -> table_department_name = FSTable_ad::_('fs_documents_department');
        $this -> table_position_name = FSTable_ad::_('fs_documents_position');
        $this -> table_field_name = FSTable_ad::_('fs_documents_field');
        $this -> table_type_name = FSTable_ad::_('fs_documents_type');
        $this -> table_word = FSTable_ad::_('fs_documents_word');
        $this -> table_excel = FSTable_ad::_('fs_documents_excel');
        $this -> table_pdf = FSTable_ad::_('fs_documents_pdf');

        $this->arr_img_paths = array(array('small', 265, 160, 'resize_image'));
        $cyear = date('Y');
        $cmonth = date('m');
        //$cday = date('d');
        $this->img_folder = 'images/document/' . $cyear . '/' . $cmonth;
        $this->check_alias = 0;
        $this->field_img = 'image';

        parent::__construct();
    }

    function setQuery() {

        // ordering
        $ordering = "";
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, date_created DESC, id DESC";
        }
        if (!$ordering)
            $ordering .= " ORDER BY date_created DESC , id DESC ";

        $where = "  ";

        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.name LIKE '%" . $keysearch . "%'  OR a.category_name LIKE '%" . $keysearch . "%'";
            }
        }
        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter) {
                $where .= ' AND a.filetype = ' . $filter . ' ';
            }
        }


        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " . $where . $ordering . " ";

        return $query;
    }

    function save($row = array(), $use_mysql_real_escape_string = 1) {

        // file downlaod
        global $db;
        

//        $image_name_image = $_FILES["image"]["name"];
//        if ($image_name_image) {
//            $image_image = $this->upload_image('image', '_' . time(), 2000000, $this->arr_img_paths);
//            if ($image_image) {
//                $row['image'] = $image_image;
//            }
//        }
        
        $category_id = FSInput::get('category_id','int',0);
            if(!$category_id){
                    Errors::_('Bạn phải chọn danh mục');
                    return;
            }
        
        $cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
        $row['category_id_wrapper'] = $cat -> list_parents;
        $row['category_alias_wrapper'] = $cat -> alias_wrapper;
        $row['category_name'] = $cat -> name;
        $row['category_alias'] = $cat -> alias;
        $row['category_published'] = $cat -> published;
        
        
        $department_id = FSInput::get('department_id','int',0);
            if(!$department_id){
                    Errors::_('Bạn phải chọn cơ quan ban hành');
                    return;
            }
        
        $department =  $this->get_record_by_id($department_id,$this -> table_department_name);
        $row['department_name'] = $department -> name;
        $row['department_alias'] = $department -> alias;
        $row['department_published'] = $department -> published;
        
        
        $position_id = FSInput::get('position_id','int',0);
            if(!$position_id){
                    Errors::_('Bạn phải chọn người ký');
                    return;
            }
        
        $position =  $this->get_record_by_id($position_id,$this -> table_position_name);
        $row['position_name'] = $position -> name;
        $row['position_alias'] = $position -> alias;
        $row['position_published'] = $position -> published;
        
        $field_id = FSInput::get('field_id','int',0);
            if(!$field_id){
                    Errors::_('Bạn phải chọn lĩnh vực');
                    return;
            }
        
        $field =  $this->get_record_by_id($field_id,$this -> table_field_name);
        $row['field_name'] = $field -> name;
        $row['field_alias'] = $field -> alias;
        $row['field_published'] = $field -> published;
        
        $type_id = FSInput::get('type_id','int',0);
            if(!$type_id){
                    Errors::_('Bạn phải chọn văn bản');
                    return;
            }        
        $type =  $this->get_record_by_id($type_id,$this -> table_type_name);
        $row['type_name'] = $type -> name;
        $row['type_alias'] = $type -> alias;
        $row['type_published'] = $type -> published;
        //print_r($row);die;

        $id = parent::save($row);
        
        // file word
        if (!$this->remove_word($id)) {
            
        }
        if (!$this->save_exist_word($id)) {
            
        }
        if (!$this->save_new_word($id)) {
            
        }
        // file excel
        if (!$this->remove_excel($id)) {
            
        }
        if (!$this->save_exist_excel($id)) {
            
        }
        if (!$this->save_new_excel($id)) {
            
        }
        // file pdf
        if (!$this->remove_pdf($id)) {
            
        }
        if (!$this->save_exist_pdf($id)) {
            
        }
        if (!$this->save_new_pdf($id)) {
            
        }
        
        return $id;
    }
    
    /*
    * select in category of home
    */
   function get_categories_tree()
   {
           global $db;
           $query = " SELECT a.*
                                     FROM 
                                           ".$this -> table_category_name." AS a
                                           ORDER BY ordering ";
           $sql = $db->query($query);
           $result = $db->getObjectList();
           $tree  = FSFactory::getClass('tree','tree/');
           $list = $tree -> indentRows2($result);
           return $list;
   }
   function get_department_tree()
   {
           global $db;
           $query = " SELECT a.*
                                     FROM 
                                           ".$this -> table_department_name." AS a
                                           ORDER BY ordering ";
           $sql = $db->query($query);
           $result = $db->getObjectList();
//           $tree  = FSFactory::getClass('tree','tree/');
//           $list = $tree -> indentRows2($result);
           return $result;
   }
   function get_position_tree()
   {
           global $db;
           $query = " SELECT a.*
                                     FROM 
                                           ".$this -> table_position_name." AS a
                                           ORDER BY ordering ";
           $sql = $db->query($query);
           $result = $db->getObjectList();
//           $tree  = FSFactory::getClass('tree','tree/');
//           $list = $tree -> indentRows2($result);
           return $result;
   }
   function get_field_tree()
   {
           global $db;
           $query = " SELECT a.*
                                     FROM 
                                           ".$this -> table_field_name." AS a
                                           ORDER BY ordering ";
           $sql = $db->query($query);
           $result = $db->getObjectList();
//           $tree  = FSFactory::getClass('tree','tree/');
//           $list = $tree -> indentRows2($result);
           return $result;
   }
   function get_type_tree()
   {
           global $db;
           $query = " SELECT a.*
                                     FROM 
                                           ".$this -> table_type_name." AS a
                                           ORDER BY ordering ";
           $sql = $db->query($query);
           $result = $db->getObjectList();
//           $tree  = FSFactory::getClass('tree','tree/');
//           $list = $tree -> indentRows2($result);
           return $result;
   }
   
   function get_document_word($document_id) {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_word . "
						  	WHERE document_id = $document_id
						  	ORDER BY id ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
   
   function get_document_excel($document_id) {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_excel . "
						  	WHERE document_id = $document_id
						  	ORDER BY id ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
   function get_document_pdf($document_id) {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_pdf . "
						  	WHERE document_id = $document_id
						  	ORDER BY id ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
   
   function remove_word($record_id) {
        if (!$record_id)
            return true;
        $other_word_remove = FSInput::get('other_word', array(), 'array');
        $str_other_word = implode(',', $other_word_remove);
        if ($str_other_word) {
            global $db;
            // remove in database
            $sql = " DELETE FROM " . $this->table_word . "
							WHERE document_id = $record_id AND id IN ($str_other_word)";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return true;
    }

    function save_exist_word($id) {
        $document = $this->get_record_by_id($id, '' . $this->table_name . '');
        global $db;
        // EXIST FIELD
        $exist_total = FSInput::get('exist_total');

        $sql_alter = "";
        $arr_sql_alter = array();
        $rs = 0;

        for ($i = 0; $i < $exist_total; $i ++) {

            $id_exist = FSInput::get('id_exist_' . $i);

            $name_exist = FSInput::get('name_exist_' . $i);
            $name_exist_begin = FSInput::get('name_exist_' . $i . "_original");
            
            $word_exist = $_FILES["word_exist_".$i]["name"];
            $word_exist_begin = FSInput::get('word_exist_' . $i . "_begin");

            if (($name_exist != $name_exist_begin) || ($word_exist != $word_exist_begin)) {
                
                $name = FSInput::get('name_exist_' . $i);
                
                $cyear = date('Y');
                $cmonth = date('m');
                $cday = date('d');
                $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
                require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
                $upload = new Upload();
                $upload->create_folder($path);

                $file_upload = $_FILES["word_exist_".$i]["name"];
                if ($file_upload) {
                    $path_original = $path;
                    // remove old if exists record and img
                    if ($id) {
                        $img_paths = array();
                        $img_paths[] = $path_original;
                    }
                    $fsFile = FSFactory::getClass('FsFiles');
                    // upload
                    $file_upload_name = $fsFile->upload_file("word_exist_".$i, $path_original, 6000000, '_' . time());
                    if (!$file_upload_name)
                        return false;
                    $content = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
                }else {
                    $content = $word_exist_begin;
                }
                
                $row = array();
                $row ['name'] = $name;
                $row ['content'] = $content;

                if (!$row ['name'] && !$row ['content']) {
                    continue;
                }
                $row ['document_name'] = $document->name;

                $u = $this->_update($row, '' . $this->table_word . '', ' id=' . $id_exist);
                if ($u)
                    $rs ++;
            }
        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_word($record_id) {
        $document = $this->get_record_by_id($record_id, '' . $this->table_name . '');
        global $db;
        for ($i = 0; $i < 20; $i ++) {
            $row = array();
            $cyear = date('Y');
            $cmonth = date('m');
            $cday = date('d');
            $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
            require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
            $upload = new Upload();
            $upload->create_folder($path);

            $file_upload = $_FILES["new_file_word_".$i]["name"];
            if ($file_upload) {
                $path_original = $path;
                // remove old if exists record and img
                if ($id) {
                    $img_paths = array();
                    $img_paths[] = $path_original;
                }
                $fsFile = FSFactory::getClass('FsFiles');
                // upload
                $file_upload_name = $fsFile->upload_file("new_file_word_".$i, $path_original, 6000000, '_' . time());
                if (!$file_upload_name)
                    return false;
                $row ['content'] = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
            }
            $row ['name'] = $file_upload;
           
            if (!$row ['name'] && !$row ['content']) {
                continue;
            }
            
            $row ['document_id'] = $record_id;
            $row ['document_name'] = $document->name;
            $row ['published'] = 1;
            $time = date ( 'Y-m-d H:i:s' );	
            $row['published_time'] = $time;
            $rs = $this->_add($row, '' . $this->table_word . '', 1);
        }
        return true;
    }
    
    
    function remove_excel($record_id) {
        if (!$record_id)
            return true;
        $other_excel_remove = FSInput::get('other_excel', array(), 'array');
        $str_other_excel = implode(',', $other_excel_remove);
        if ($str_other_excel) {
            global $db;
            // remove in database
            $sql = " DELETE FROM " . $this->table_excel . "
							WHERE document_id = $record_id AND id IN ($str_other_excel)";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return true;
    }

    function save_exist_excel($id) {
        $document = $this->get_record_by_id($id, '' . $this->table_name . '');
        global $db;
        // EXIST FIELD
        $exist_total = FSInput::get('exist_total_excel');

        $sql_alter = "";
        $arr_sql_alter = array();
        $rs = 0;

        for ($i = 0; $i < $exist_total; $i ++) {

            $id_exist = FSInput::get('id_exist_' . $i);

            $name_exist = FSInput::get('name_exist_excel' . $i);
            $name_exist_begin = FSInput::get('name_exist_excel' . $i . "_original");
            
            $excel_exist = $_FILES["excel_exist_".$i]["name"];
            $excel_exist_begin = FSInput::get('excel_exist_' . $i . "_begin");

            if (($name_exist != $name_exist_begin) || ($excel_exist != $excel_exist_begin)) {
                
                $name = FSInput::get('name_exist_excel_' . $i);
                
                $cyear = date('Y');
                $cmonth = date('m');
                $cday = date('d');
                $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
                require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
                $upload = new Upload();
                $upload->create_folder($path);

                $file_upload = $_FILES["excel_exist_".$i]["name"];
                if ($file_upload) {
                    $path_original = $path;
                    // remove old if exists record and img
                    if ($id) {
                        $img_paths = array();
                        $img_paths[] = $path_original;
                    }
                    $fsFile = FSFactory::getClass('FsFiles');
                    // upload
                    $file_upload_name = $fsFile->upload_file("excel_exist_".$i, $path_original, 6000000, '_' . time());
                    if (!$file_upload_name)
                        return false;
                    $content = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
                }else {
                    $content = $excel_exist_begin;
                }
                
                $row = array();
                $row ['name'] = $name;
                $row ['content'] = $content;

                if (!$row ['name'] && !$row ['content']) {
                    continue;
                }
                $row ['document_name'] = $document->name;

                $u = $this->_update($row, '' . $this->table_excel . '', ' id=' . $id_exist);
                if ($u)
                    $rs ++;
            }
        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_excel($record_id) {
        $document = $this->get_record_by_id($record_id, '' . $this->table_name . '');
        global $db;
        for ($i = 0; $i < 20; $i ++) {
            $row = array();
            $cyear = date('Y');
            $cmonth = date('m');
            $cday = date('d');
            $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
            require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
            $upload = new Upload();
            $upload->create_folder($path);

            $file_upload = $_FILES["new_file_excel_".$i]["name"];
            if ($file_upload) {
                $path_original = $path;
                // remove old if exists record and img
                if ($id) {
                    $img_paths = array();
                    $img_paths[] = $path_original;
                }
                $fsFile = FSFactory::getClass('FsFiles');
                // upload
                $file_upload_name = $fsFile->upload_file("new_file_excel_".$i, $path_original, 6000000, '_' . time());
                if (!$file_upload_name)
                    return false;
                $row ['content'] = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
            }
            $row ['name'] = $file_upload;
           
            if (!$row ['name'] && !$row ['content']) {
                continue;
            }
            
            $row ['document_id'] = $record_id;
            $row ['document_name'] = $document->name;
            $row ['published'] = 1;
            $time = date ( 'Y-m-d H:i:s' );	
            $row['published_time'] = $time;
            $rs = $this->_add($row, '' . $this->table_excel . '', 1);
        }
        return true;
    }
    
    function remove_pdf($record_id) {
        if (!$record_id)
            return true;
        $other_pdf_remove = FSInput::get('other_pdf', array(), 'array');
        $str_other_pdf = implode(',', $other_pdf_remove);
        if ($str_other_pdf) {
            global $db;
            // remove in database
            $sql = " DELETE FROM " . $this->table_pdf . "
							WHERE document_id = $record_id AND id IN ($str_other_pdf)";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return true;
    }

    function save_exist_pdf($id) {
        $document = $this->get_record_by_id($id, '' . $this->table_name . '');
        global $db;
        // EXIST FIELD
        $exist_total = FSInput::get('exist_total_pdf');

        $sql_alter = "";
        $arr_sql_alter = array();
        $rs = 0;

        for ($i = 0; $i < $exist_total; $i ++) {

            $id_exist = FSInput::get('id_exist_' . $i);

            $name_exist = FSInput::get('name_exist_pdf' . $i);
            $name_exist_begin = FSInput::get('name_exist_pdf' . $i . "_original");
            
            $pdf_exist = $_FILES["pdf_exist_".$i]["name"];
            $pdf_exist_begin = FSInput::get('pdf_exist_' . $i . "_begin");

            if (($name_exist != $name_exist_begin) || ($pdf_exist != $pdf_exist_begin)) {
                
                $name = FSInput::get('name_exist_pdf_' . $i);
                
                $cyear = date('Y');
                $cmonth = date('m');
                $cday = date('d');
                $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
                require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
                $upload = new Upload();
                $upload->create_folder($path);

                $file_upload = $_FILES["pdf_exist_".$i]["name"];
                if ($file_upload) {
                    $path_original = $path;
                    // remove old if exists record and img
                    if ($id) {
                        $img_paths = array();
                        $img_paths[] = $path_original;
                    }
                    $fsFile = FSFactory::getClass('FsFiles');
                    // upload
                    $file_upload_name = $fsFile->upload_file("pdf_exist_".$i, $path_original, 60000000, '_' . time());
                    if (!$file_upload_name)
                        return false;
                    $content = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
                }else {
                    $content = $pdf_exist_begin;
                }
                
                $row = array();
                $row ['name'] = $name;
                $row ['content'] = $content;

                if (!$row ['name'] && !$row ['content']) {
                    continue;
                }
                $row ['document_name'] = $document->name;

                $u = $this->_update($row, '' . $this->table_pdf . '', ' id=' . $id_exist);
                if ($u)
                    $rs ++;
            }
        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_pdf($record_id) {
        $document = $this->get_record_by_id($record_id, '' . $this->table_name . '');
        global $db;
        for ($i = 0; $i < 20; $i ++) {
            $row = array();
            $cyear = date('Y');
            $cmonth = date('m');
            $cday = date('d');
            $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
            require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
            $upload = new Upload();
            $upload->create_folder($path);

            $file_upload = $_FILES["new_file_pdf_".$i]["name"];
            if ($file_upload) {
                $path_original = $path;
                // remove old if exists record and img
                if ($id) {
                    $img_paths = array();
                    $img_paths[] = $path_original;
                }
                $fsFile = FSFactory::getClass('FsFiles');
                // upload
                $file_upload_name = $fsFile->upload_file("new_file_pdf_".$i, $path_original, 60000000, '_' . time());
                if (!$file_upload_name)
                    return false;
                $row ['content'] = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
            }
            $row ['name'] = $file_upload;
           
            if (!$row ['name'] && !$row ['content']) {
                continue;
            }
            
            $row ['document_id'] = $record_id;
            $row ['document_name'] = $document->name;
            $row ['published'] = 1;
            $time = date ( 'Y-m-d H:i:s' );	
            $row['published_time'] = $time;
            $rs = $this->_add($row, '' . $this->table_pdf . '', 1);
        }
        return true;
    }

}

?>