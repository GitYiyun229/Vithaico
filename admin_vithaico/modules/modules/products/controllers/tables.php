<?php
	// models 
	class ProductsControllersTables  extends Controllers
	{
		function __construct()
		{
			$this -> type = 'products';
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			// call models
			$model = $this -> model;
			// print_r($model->get_data(''));die;
			$list = $model->get_data('');
			$group_field = $model->get_group_field();
			$foreign_data = $model->get_foreign_data();
			$pagination = $model->getPagination('');
			// call views
			
			include 'modules/'.$this->module.'/views/tables/list.php';
		}
		function edit()
		{
			$model = $this -> model;
			$data = $model->getTableFields();
			$group_field = $model->get_group_field();
			$foreign_data = $model->get_foreign_data();
			
			// default field
			$fields_default = $model->get_default_fields_in_extends();
			$str_field_default = 'id, record_id';
    		foreach($fields_default as $item)
    			$str_field_default .= ', '.$item -> field_name;
			
			include 'modules/'.$this->module.'/views/tables/detail.php';
		}
		
		
		//*********** FIELD ***************/
		function apply_edit()
		{
			$model = $this -> model;
			$tablename = FSInput::get('table_name');
			$tablename = strtolower($tablename);
			$tablename = $tablename;
			$rs = $model->save_edit();
			if($rs)
			{
				$cid = FSInput::get('cid');
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$rs",FSText::_('Saved'));
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
			
		}
		function save_edit()
		{
			$model = $this -> model;
			$rs = $model->save_edit();
			if($rs)
			{
				$cid = FSInput::get('cid');
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Saved'));
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		
		function cancel()
		{
			setRedirect("index.php?module=".$this -> module.'&view='.$this -> view);
		}
		
		/*
		 * Create table
		 */
		function apply_new()
		{
			$model = $this -> model;
			$rs = $model->table_new();
			if($rs)
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$rs","L&#432;u th&#224;nh c&#244;ng");
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		/*
		 * Create table
		 */
		function save_new()
		{
			$model = $this -> model;
			$rs = $model->table_new();
			if($rs)
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,"L&#432;u th&#224;nh c&#244;ng");
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		
		function table_add()
		{
			$model = $this -> model;
			$group_field = $model->get_group_field();
			$foreign_data = $model->get_foreign_data();
			// default field
			$fields_default = $model->get_default_fields_in_extends();
			$str_field_default = 'id, record_id';
    		foreach($fields_default as $item)
    			$str_field_default .= ', '.$item -> field_name;
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		/*
		 * create Filter
		 */
		function filter()
		{
			$tablename  = FSInput::get('table_name');
			
			if($tablename)
			{
				setRedirect("index.php?module=".$this -> module."&view=filters&tablename=$tablename");
			}
			else
			{
				$this->table_add();
			}
		}

		function ajax_get_group(){
			$id = FSInput::get('id');
			$extend_field = $this->model->get_record('id = '.$id,'fs_extends_groups');
			if($extend_field->field_group)
				echo $extend_field->field_group;
			else
				echo 0;	
		}
		
		function save_new_extend_field(){
			$fsstring = FSFactory::getClass('FSString','','../');
			$total = count(FSInput::get('eg_name','','array'));
			for($i = 0; $i < $total; $i++){
				$name = FSInput::get('eg_name','','array')[$i];
				$alias = $fsstring->stringStandart(FSInput::get('eg_alias','','array')[$i]);
				$field_group = FSInput::get('eg_field','','array')[$i];
				$field_type = FSInput::get('eg_type','','array')[$i];
				$order = FSInput::get('eg_order','','array')[$i];
				if($name != ''){
					$row = array();
					$row['name'] = $name;
					$row['alias'] = $alias ? $alias : $fsstring->stringStandart($name);
					$row['field_group'] = $field_group;
					$row['field_type'] = $field_type;
					$row['ordering'] = $order ? $order : 0;
					$row['created_time'] = date('Y-m-d H:i:s');
					$row['updated_time'] = date('Y-m-d H:i:s');
					$this->model->_add($row,'fs_extends_groups',1);
				}
			}
			$redirect = FSInput::get('redirect');
			setRedirect('index.php?module=products&view=tables&task=edit&tablename='.$redirect,'Đã lưu','success');
		}

		function save_new_extend_field_group(){
			$total = count(FSInput::get('efg_name','','array'));
			for($i = 0; $i < $total; $i++){
				$name = FSInput::get('efg_name','','array')[$i];
				$order = FSInput::get('efg_order','','array')[$i];
				if($name != ''){
					$row = array();
					$row['name'] = $name;
					$row['ordering'] = $order ? $order : 0;
					$row['created_time'] = date('Y-m-d H:i:s');
					$row['published'] = 1;
					$save = $this->model->_add($row,'fs_products_fields_groups',1);
				}
			}
			$redirect = FSInput::get('redirect');
			setRedirect('index.php?module=products&view=tables&task=edit&tablename='.$redirect,'Đã lưu','success');
		}

		function ajax_get_detail_field(){
			$id = FSInput::get('id');
			$tablename = FSInput::get('tablename');
			$this->genarate_detail_field_html($id,$tablename);
		}

		function genarate_detail_field_html($id,$tablename)
		{
			$list = $this->model->get_records('group_id = '.$id,'fs_extends_items');
			$list_group = $this->model->get_records('published = 1','fs_extends_groups');
			$html = '';
			$html .= '
			<input type="hidden" name="group_id" value="'.$id.'">
			<input type="hidden" name="redirect" value="'.$tablename.'">
			<table class="table">
				<thead>
					<th>Tên</th>
					<th>Tên hiệu</th>
					<th width="20%">Nhóm</th>
					<th width="100">Thứ tự</th>
				</thead>
				<tbody>
			';
			foreach($list as $item){
				$html .= "
				<tr>
					<td><input name='ex_name[]' type='text' class='form-control' placeholder='Tên' value='".$item->name."'></td>
					<td><input name='ex_alias[]' type='text' class='form-control' placeholder='Tên hiệu (Có thể sinh tự động)' value='".$item->alias."'></td>
					<td>
						<select name='ex_group[]' class='select2-box'>
				";		
				foreach($list_group as $group){
					$check =  $item->group_id == $group->id ? 'selected' : '';
					$html .= "<option value='".$group->id."' ".$check.">".$group->name."</option>";
				}
				$html .= "
						</select>	
					</td>
					<td><input name='ex_order[]' type='text' class='form-control' placeholder='Thứ tự' value='".$item->ordering."'></td>
				</tr>
				";
			}
			$html .='
				</tbody>
			</table>
			<div style="display:flex; justify-content: space-between;">
				<a href="javascript:void(0)" style="color:#333" onclick="addFieldModal(3,'.$id.')">
					<i class="fa fa-lg fa-plus-square-o"></i>
					Thêm
				</a>
				<a href="javascript:void(0)" class="btnSaveDetail btn btn-primary">Lưu</a>
				<input type="hidden" name="total_old" id="total_old" value="'.count($list).'">
				<input type="hidden" name="total_new" id="total_new" value="0">
			</div>
			<script>$(document).ready(function(){$(".select2-box").select2();})</script>
			';
			echo $html;
		}

		function ajax_save_detail_field(){
			$fsstring = FSFactory::getClass('FSString','','../');
			$total_new = FSInput::get('total_new');
			for($i = 0; $i < $total_new; $i++){
				$name = FSInput::get('new_name','','array')[$i];
				$alias = $fsstring->stringStandart(FSInput::get('new_alias','','array')[$i]);
				$group_id = FSInput::get('new_group','','array')[$i];
				$order = FSInput::get('new_order','','array')[$i];
				if($name != ''){
					$row = array();
					$row['name'] = $name;
					$row['alias'] = $alias ? $alias : $fsstring->stringStandart($name);
					$row['group_id'] = $group_id;
					$row['ordering'] = $order ? $order : 0;
					$row['created_time'] = date('Y-m-d H:i:s');
					$row['edited_time'] = date('Y-m-d H:i:s');
					$row['published'] = 1;
					$rs = $this->model->_add($row,'fs_extends_items',1);
				}
			}
			$tablename = FSInput::get('redirect');
			$id = FSInput::get('group_id');
			$this->genarate_detail_field_html($id,$tablename);
		}
	}
	
?>