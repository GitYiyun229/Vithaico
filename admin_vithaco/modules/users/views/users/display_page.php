<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-pop" action="index.php?module=users&view=users" method="POST" id="form-pop" name="form-pop">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo FSText::_('Phân quyền nội dung module').' '.$n_module; ?></h4>
                </div>
                <?php if(count($list_field)){ ?>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover able-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên trường</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($list_field as $item){ 
                                    
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="list_field[]" value="<?php echo $item->field ?>" <?php echo strpos(@$data->list_field,','.$item->field.',') !== false? 'checked="checked"':''; ?> /> <?php echo $item->name ?>
                                        </label>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo FSText::_('Cancel'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo FSText::_('Lưu'); ?></button>
                </div>
                <input type="hidden"  name="n_module" value="<?php echo $n_module ?>"/>
                <input type="hidden"  name="n_view" value="<?php echo $n_view ?>"/>
                <input type="hidden" value="<?php echo $user_id ?>" name="user_id" />
                <input type="hidden" value="users" name="module" />
                <input type="hidden" value="users" name="view" />
                <input type="hidden" value="save_field_permission" name="task" />
                <?php }else{ ?>
                    <div class="modal-body">
                        <p><?php echo FSText::_('Chưa cập nhật dữ liệu nội dung của module này') ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo FSText::_('Cancel'); ?></button>
                    </div>
                <?php } ?>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>