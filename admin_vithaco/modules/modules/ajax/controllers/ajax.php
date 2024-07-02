<?php
class AjaxControllersAjax extends Controllers{
    var $extend_field_type = array(
//        'text' => 'Text',
        'select' => 'Select',
        'multi_select' => 'Multi select',
//        'yesno' => 'Yes/No'
    );

    function __construct(){
        parent::__construct();
    }

    function load_extend_fields(){
        $fields = $this->model->load_extend_fields();
        $extends_groups = $this->model->load_extends_groups();
        $extend_category_id = intval(FSInput::get('extend_category_id', ''));
        foreach ($fields as $item){
            $extend_number = $item->id;
            $disabled = false;
            if($extend_category_id!=0 && $item->category_id!=$extend_category_id)
                $disabled = true;
        ?>
        <tr>
            <td>
                <input <?php if($disabled) echo 'disabled';?> type="text" class="form-control" name="field_name" value="<?php echo $item->field_name ?>" id="field_name_<?php echo $extend_number?>">
            </td>
            <td>
                <select <?php if($disabled) echo 'disabled';?> class="form-control" name="field_type" id="field_type_<?php echo $extend_number?>" onclick="change_field_type(<?php echo $extend_number?>);">
                    <?php foreach ($this->extend_field_type as $key=>$val){ ?>
                        <option <?php if($item->field_type==$key) echo 'selected' ?> value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select <?php if(($item->field_type!='select' && $item->field_type!='multi_select') || $disabled) echo 'disabled'; ?>  class="form-control" name="field_table" id="field_table_<?php echo $extend_number?>">
                    <option value=""></option>
                    <?php foreach ($extends_groups as $eg){ ?>
                        <option <?php if($item->field_table==$eg->id) echo 'selected' ?> value="<?php echo $eg->id ?>"><?php echo $eg->name ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input size="3" <?php if($disabled) echo 'disabled';?> type="number" class="form-control" name="ordering" value="<?php echo $item->ordering ?>" id="ordering_<?php echo $extend_number?>">
            </td>
            <td align="center">
                <?php if(!$disabled){ ?>
                    <input <?php if($disabled) echo 'disabled';?> <?php if($item->childs==1) echo 'checked'; ?>  type="checkbox" name="childs" id="childs_<?php echo $extend_number?>">
                <?php } ?>
            </td>
            <td>
                <?php if(!$disabled){ ?>
                    &nbsp;
                    <a href="javascript:void(0)" onclick="save_extend_fields(this, <?php echo $extend_number?>);">
                        <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/save.png" />
                    </a>
                    &nbsp;
                    <a href="javascript:void(0)" onclick="del_extend_fields(<?php echo $extend_number?>);">
                        <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/remove (2).gif" />
                    </a>
                    <input type="hidden" id="extend_id_<?php echo $extend_number?>" name="extend_id" value="<?php echo $item->id ?>" />
                <?php } ?>
            </td>
        </tr>
        <?php
        }
    }

    function add_extend_fields(){
        $extend_number = FSInput::get('extend_number', 0);
        $extends_groups = $this->model->load_extends_groups();
        ?>
        <tr>
            <td>
                <input type="text" class="form-control" name="field_name" id="field_name_<?php echo $extend_number?>">
            </td>
            <td>
                <select class="form-control" name="field_type" id="field_type_<?php echo $extend_number?>" onclick="change_field_type(<?php echo $extend_number?>);">
                    <?php foreach ($this->extend_field_type as $key=>$val){ ?>
                        <option value="<?php echo $key?>"><?php echo $val?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select disabled class="form-control" name="field_table" id="field_table_<?php echo $extend_number?>">
                    <option value=""></option>
                    <?php foreach ($extends_groups as $eg){ ?>
                        <option value="<?php echo $eg->id ?>"><?php echo $eg->name ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input size="3" type="number" class="form-control" name="ordering" id="ordering_<?php echo $extend_number?>">
            </td>
            <td align="center">
                <input type="checkbox" name="childs" id="childs_<?php echo $extend_number?>">
            </td>
            <td>
                &nbsp;
                <a href="javascript:void(0)" onclick="save_extend_fields(this, <?php echo $extend_number?>);">
                    <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/save_add.png" />
                </a>
                &nbsp;
                <input type="hidden" id="extend_id_<?php echo $extend_number?>" name="extend_id" value="0" />
            </td>
        </tr>
        <?php
    }

    function save_extend_fields(){
        $json = array('error'=>false);
        $field_name = FSInput::get('field_name', '');
        $fsstring = FSFactory::getClass('FSString','','../');
        $field = $fsstring->stringStandart($field_name);
        $field_type = FSInput::get('field_type', '');
        $field_table = FSInput::get('field_table', '');
	    $ordering = FSInput::get('ordering', 0);
        $extend_category_id = intval(FSInput::get('extend_category_id', 0));
        $childs = intval(FSInput::get('childs', 0));
        $temp = session_id();
        if($extend_category_id)
            $temp = '';

        $extend_id = FSInput::get('extend_id', 0);
        if($extend_id)
            $this->model->_update(array(
                'category_id'=>$extend_category_id,
                'field'=>$field,
                'field_name'=>$field_name,
                'field_type'=>$field_type,
                'field_table'=>$field_table,
                'temp'=>$temp,
                'childs'=>$childs,
                'ordering' => $ordering,
                'created_time' => date('Y-m-d H:i:s')
            ), 'fs_products_extend_fields', 'id='.intval($extend_id));
        else
            $this->model->_add(array(
                'category_id'=>$extend_category_id,
                'field'=>$field,
                'field_name'=>$field_name,
                'field_type'=>$field_type,
                'field_table'=>$field_table,
                'temp'=>$temp,
                'childs'=>$childs,
	            'ordering' => $ordering,
                'created_time' => date('Y-m-d H:i:s')
            ), 'fs_products_extend_fields');
        echo json_encode($json);
    }

    function save_field_tables(){
        $json = array('error'=>false);
        $name = FSInput::get('name', '');
        $ordering = FSInput::get('ordering', 0);
        $published = FSInput::get('published', 0);
        $group_id = FSInput::get('group_id', 0);

        if($group_id)
            $this->model->_update(array(
                'name'=>$name,
                'ordering'=>$ordering,
                'published'=>$published,
                'created_time' => date('Y-m-d H:i:s')
            ), 'fs_extends_groups', 'id='.intval($group_id));
        else
            $this->model->_add(array(
                'name'=>$name,
                'ordering'=>$ordering,
                'published'=>$published,
                'created_time' => date('Y-m-d H:i:s')
            ), 'fs_extends_groups');
        echo json_encode($json);
    }

    function del_extend_fields(){
        $json = array('error'=>false);
        $extend_id = FSInput::get('extend_id', 0);
        $this->model->_remove('id='.$extend_id, 'fs_products_extend_fields');
        echo json_encode($json);
    }

    function load_field_tables(){
        $tables = $this->model->load_field_tables();
        foreach ($tables as $item) {
            $extend_number = $item->id;
            ?>
            <tr>
                <td>
                    <input type="text" class="form-control" name="ft_name" value="<?php echo $item->name ?>" id="ft_name_<?php echo $extend_number?>">
                </td>
                <td>
                    <input type="text" class="form-control" name="ft_ordering" value="<?php echo $item->ordering ?>" id="ft_ordering_<?php echo $extend_number?>">
                </td>
                <td align="center">
                    <input type="checkbox" <?php if($item->published==1) echo 'checked'; ?> name="ft_published" id="ft_published_<?php echo $extend_number?>">
                </td>
                <td style="width: 80px" align="center">
                    &nbsp;
                    <a href="javascript:void(0)" onclick="save_field_tables(this, <?php echo $extend_number?>);">
                        <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/save.png" />
                    </a>
                    &nbsp;
                    <a href="javascript:void(0)" onclick="del_field_tables(<?php echo $extend_number?>);">
                        <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/remove (2).gif" />
                    </a>
                    <input type="hidden" id="ft_group_id_<?php echo $extend_number?>" name="extend_id" value="<?php echo $item->id ?>" />
                </td>
            </tr>
            <?php
        }
    }

    function del_field_tables(){
        $json = array('error'=>false);
        $group_id = FSInput::get('group_id', 0);
        $this->model->_remove('id='.$group_id, 'fs_extends_groups');
        echo json_encode($json);
    }

    function add_field_tables(){
        $extend_number = FSInput::get('extend_number', 0);
        ?>
        <tr>
            <td>
                <input type="text" class="form-control" name="name" value="" id="ft_name_<?php echo $extend_number?>">
            </td>
            <td>
                <input type="text" class="form-control" name="ordering" value="" id="ft_ordering_<?php echo $extend_number?>">
            </td>
            <td align="center">
                <input type="checkbox" name="published" id="ft_published_<?php echo $extend_number?>">
            </td>
            <td style="width: 80px" align="center">
                <a href="javascript:void(0)" onclick="save_field_tables(this, <?php echo $extend_number?>);">
                    <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/save_add.png" />
                </a>
                <input type="hidden" id="ft_group_id_<?php echo $extend_number?>" name="extend_id" value="0" />
            </td>
        </tr>
        <?php
    }

    function add_filter_price(){
        $extend_number = FSInput::get('extend_number', 0);
        ?>
        <tr>
            <td>
                <input type="text" class="form-control" name="title" id="fp_title_<?php echo $extend_number?>">
            </td>
            <td>
                <input type="text" class="form-control" name="p_alias" id="fp_title_<?php echo $extend_number?>">
            </td>
            <td>
                <input type="text" class="form-control" name="min" id="fp_min_<?php echo $extend_number?>">
            </td>
            <td>
                <input type="text" class="form-control" name="max" id="fp_max_<?php echo $extend_number?>">
            </td>
            <td>
                <input type="text" class="form-control" name="ordering" id="fp_ordering_<?php echo $extend_number?>">
            </td>
            <td align="center">
                <input type="checkbox" name="childs" id="fp_childs_<?php echo $extend_number?>">
            </td>
            <td>
                &nbsp;
                <a href="javascript:void(0)" onclick="save_filter_price(this, <?php echo $extend_number?>);">
                    <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/save_add.png" />
                </a>
                &nbsp;
                <input type="hidden" id="fp_price_id_<?php echo $extend_number?>" name="fp_price_id" value="0" />
            </td>
        </tr>
        <?php
    }

    function save_filter_price(){
        $json = array('error'=>false);
        $title = FSInput::get('title', '');
        $min = FSInput::get('min', '');
        $max = FSInput::get('max', '');
        $alias = FSInput::get('p_alias','');
        $fsstring = FSFactory::getClass('FSString','','../');
        if(!$alias){
            $alias = $fsstring -> stringStandart3($title);
        } else {
            $alias = $fsstring -> stringStandart3($alias);
        }
        $ordering = FSInput::get('ordering', '');
        $price_category_id = intval(FSInput::get('price_category_id', 0));
        $childs = intval(FSInput::get('childs', 0));
        $temp = session_id();
        if($price_category_id)
            $temp = '';

        $price_id = FSInput::get('price_id', 0);
        if($price_id)
            $this->model->_update(array(
                'category_id'=>$price_category_id,
                'title'=>$title,
                'min'=>doubleval($min),
                'max'=>doubleval($max),
                'ordering'=>$ordering,
                'temp'=>$temp,
                'childs'=>$childs,
                'created_time' => date('Y-m-d H:i:s'),
                'alias'=>$alias
            ), 'fs_products_filter_price', 'id='.intval($price_id));
        else
            $this->model->_add(array(
                'category_id'=>$price_category_id,
                'title'=>$title,
                'min'=>$min,
                'max'=>$max,
                'ordering'=>$ordering,
                'temp'=>$temp,
                'childs'=>$childs,
                'created_time' => date('Y-m-d H:i:s'),
                'alias'=>$alias
            ), 'fs_products_filter_price');
        echo json_encode($json);
    }

    function load_filter_price(){
        $prices = $this->model->load_filter_price();
        $price_category_id = intval(FSInput::get('price_category_id', ''));
        foreach ($prices as $item){
            $extend_number = $item->id;
            $disabled = false;
            if($price_category_id!=0 && $item->category_id!=$price_category_id)
                $disabled = true;
            ?>
            <tr>
                <td>
                    <input <?php if($disabled) echo 'disabled';?> type="text" class="form-control" name="title" value="<?php echo $item->title ?>" id="fp_title_<?php echo $extend_number?>">
                </td>
                <td>
                    <input <?php if($disabled) echo 'disabled';?> type="text" class="form-control" name="p_alias" value="<?php echo $item->alias ?>" id="fp_alias_<?php echo $extend_number?>">
                </td>
                <td>
                    <input <?php if($disabled) echo 'disabled';?> type="text" class="form-control" name="min" value="<?php echo $item->min ?>" id="fp_min_<?php echo $extend_number?>">
                </td>
                <td>
                    <input <?php if($disabled) echo 'disabled';?> type="text" class="form-control" name="max" value="<?php echo $item->max ?>" id="fp_max_<?php echo $extend_number?>">
                </td>
                <td>
                    <input <?php if($disabled) echo 'disabled';?> type="text" class="form-control" name="ordering" value="<?php echo $item->ordering ?>" id="fp_ordering_<?php echo $extend_number?>">
                </td>
                <td align="center">
                    <?php if(!$disabled){ ?>
                        <input <?php if($disabled) echo 'disabled';?> <?php if($item->childs==1) echo 'checked'; ?>  type="checkbox" name="childs" id="fp_childs_<?php echo $extend_number?>">
                    <?php } ?>
                </td>
                <td>
                    <?php if(!$disabled){ ?>
                        &nbsp;
                        <a href="javascript:void(0)" onclick="save_filter_price(this, <?php echo $extend_number?>);">
                            <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/save.png" />
                        </a>
                        &nbsp;
                        <a href="javascript:void(0)" onclick="del_filter_price(<?php echo $extend_number?>);">
                            <img src="/<?=URL_ROOT_ADMIN?>templates/default/images/toolbar/remove (2).gif" />
                        </a>
                        <input type="hidden" id="fp_price_id_<?php echo $extend_number?>" name="fp_price_id" value="<?php echo $item->id ?>" />
                    <?php } ?>
                </td>
            </tr>
            <?php
        }
    }

    function del_filter_price(){
        $json = array('error'=>false);
        $extend_id = FSInput::get('extend_id', 0);
        $this->model->_remove('id='.$extend_id, 'fs_products_filter_price');
        echo json_encode($json);
    }
}