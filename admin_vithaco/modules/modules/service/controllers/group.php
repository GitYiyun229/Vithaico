<?php
	class ServiceControllersGroup  extends Controllers
	{
		function __construct()
		{
			$this->view = 'group' ;
			parent::__construct();
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;

			$model  = $this -> model;
			$list = $model->get_data('');

			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
            
            $uploadConfig = base64_encode('add|'.session_id());
            $list_quanrity2 = $model->get_records(' session_id = "'.$uploadConfig.'" ','fs_members_service_group_config');
            
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}


		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
            
            $list_quanrity2 = $model->get_records(' is_type = 1 AND service_id = '.$data->id,'fs_members_service_group_config');
            
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        
        function save_item(){
            $model = $this -> model;
            $rs = $model->save_item();
            
            $quanrity = FSInput::get2('quanrity',1,'int');
            $sale = FSInput::get2('sale',0,'int');
            $type = FSInput::get2('type',0,'int');
            $quanrity_text = FSInput::get('quanrity_text'); 
            $calculators = FSInput::get2('calculators',0,'int');
            
            $calculators_lisst  = array(
							1 => '==',
							2 => '>',
							3 => '<',
							4 => '>= ',
							5 => ' <= ',
							6 => ' > value1 AND < value2',
							7 => ' > value1 AND <= value2',
							8 => ' >= value1 AND < value2',
							9 => ' >= value1 AND <= value2 ',
						);
                                   
            $data = array(
                        'messages'=>'',
                        'html'=>'',
                        'error'=>false,
                        'id'=>0,
                    );
                    
            if($rs){
                if($type == 1){
                    $data['html'] .= '<td class="stt2"></td>';
                    $data['html'] .= '<td><input class="form-control" type="text" id="item2_quanrity_'.$rs.'" value="'.$quanrity_text.'"/></td>';
                    $data['html'] .= '<td>';
                    $data['html'] .= '<select class="form-control chosen-select" id="item2_calculators_'.$rs.'">';
                    $data['html'] .= '<option value="">'.FSText::_('Tính toán').'</option>';
                    foreach($calculators_lisst as $key => $value){ 
                        $selected = $calculators && $calculators == $key? 'selected="selected"':'';
                        $data['html'] .= '<option value="'.$key.'" '.$selected.' >'.$value.'</option>';
                    }
                    $data['html'] .= '</select>';
                    $data['html'] .= '</td>';
                    $data['html'] .= '<td><input class="form-control" type="number" id="item2_sale_'.$rs.'" value="'.$sale.'" min="0" /></td>';
                    $data['html'] .= '<td><p class="help-block">%</p></td>';
                    $data['html'] .= '<td><a class="btn btn-outline btn-primary save" onclick="save2_item('.$rs.',1)" ><i class="fa fa-save"></i></a></td>';
                    $data['html'] .= '<td><a class="btn btn-outline btn-danger delete" onclick="delete2_item('.$rs.',1)" ><i class="fa fa-remove"></i></a></td>';
                }else{
                    $data['html'] .= '';
                    $data['html'] .='<td class="stt"></td>';
                    $data['html'] .='<td><input class="form-control" type="number" id="item_quanrity_'.$rs.'" min="1"  value="'.$quanrity.'"/></td>';
                    $data['html'] .='<td><input class="form-control" type="number" id="item_sale_'.$rs.'" value="'.$sale.'"  /></td>';
                    $data['html'] .='<td><p class="help-block">%</p></td>';
                    $data['html'] .='<td><a class="btn btn-outline btn-primary save" onclick="save_item('.$rs.',1)" ><i class="fa fa-save"></i></a></td>';
                    $data['html'] .='<td><a class="btn btn-outline btn-danger delete" onclick="delete_item('.$rs.',1)" ><i class="fa fa-remove"></i></a></td>';
                }
 
                $data['error'] = true;
                $data['id'] = $rs;
            }
            
            echo json_encode($data);
            return;
        }
        
        function delete_item(){
            $ids = FSInput::get2('ids',0,'int');
            $model = $this -> model;
            
            $rs = $model->_remove(' id = '.$ids,'fs_members_service_group_config');
            if($rs){
              echo 1;  
            }else{
              echo 0;  
            }
        }


	}

?>
