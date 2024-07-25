<div class="col-md-9">
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-edit"></i> Sửa Tin tức</div>
            <?php
            TemplateHelper::dt_edit_text(FSText:: _('Tiêu đề tin'), 'title', @$data->title);
            TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
            TemplateHelper::dt_edit_image(FSText:: _('Hình ảnh'), 'image', str_replace('/original/', '/small/', URL_ROOT . @$data->image));
            TemplateHelper::dt_edit_selectbox(FSText::_('Categories'), 'category_id', @$data->category_id, 0, $categories, $field_value = 'id', $field_label = 'treename', $size = 10, 0, 1,'','','','col-md-3','col-md-5');
            TemplateHelper::datetimepicke(FSText:: _('Published time'), 'created_time', @$data->created_time ? @$data->created_time : date('Y-m-d H:i:s'), FSText:: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-5');
            TemplateHelper::datetimepicke(FSText:: _('End time (Đối với Tin tuyển dụng)'), 'end_time', @$data->end_time ? @$data->end_time : date('Y-m-d H:i:s'), FSText:: _('Bạn vui lòng chọn thời gian hiển thị'), 20, '', 'col-md-3', 'col-md-5');
            TemplateHelper::dt_edit_text(FSText:: _('Địa điểm (Đối với Tin tuyển dụng)'), 'address', @$data->address);
            ?>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-user"></i> Quản trị</div>
            <?php
            TemplateHelper::dt_text(FSText:: _('Người tạo'), @$data->author, '', '', '', 'col-md-6', 'col-md-6');
            TemplateHelper::dt_text(FSText:: _('Người sửa cuối'), @$data->author_last, '', '', '', 'col-md-6', 'col-md-6');
            ?>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-unlock"></i> Kích hoạt</div>
            <?php
            TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-sm-4', 'col-sm-8');
            TemplateHelper::dt_checkbox(FSText::_('Trang chủ'), 'show_in_homepage', @$data->show_in_homepage, 0, '', '', '', 'col-sm-4', 'col-sm-8');
            TemplateHelper::dt_checkbox(FSText::_('Hot'), 'is_hot', @$data->is_hot, 0, '', '', '', 'col-sm-4', 'col-sm-8');
            TemplateHelper::dt_checkbox(FSText::_('Hiển thị Mục lục'), 'indexcontent', @$data->indexcontent, 1, '', '', 'Tự động lấy thẻ H2, H3 lên mục lục', 'col-sm-4', 'col-sm-8');
            TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '', '', 0, '', '', 'col-sm-4', 'col-sm-8');

            ?>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="panel-heading"><i class="fa fa-info"></i> Nội dung</div>
            <?php
            TemplateHelper::dt_edit_text(FSText:: _(''), 'content', @$data->content, '', 650, 450, 1, '', '', 'col-sm-2', 'col-sm-12');
            ?>
        </div>
        <!--<div class="col-md-10">
    <script src="/libraries/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="/libraries/tinymce/js/global.js"></script>
    <textarea id="content" name="content" cols="30" rows="40"><?php /*echo @$data->content; */?></textarea>
    <script>
        tinymce.init({
            selector: 'textarea#editor',  //Change this value according to your HTML
            auto_focus: 'element1',
            plugins: "image bbcode code",
            width: "100%",
            height : "980",
            toolbar: 'undo redo | image code',
            images_upload_url: 'postAcceptor.php',

        });
        tinymce.init({



            images_upload_handler: function (blobInfo, success, failure) {
                setTimeout(function () {
                    /* no matter what you upload, we will turn it into TinyMCE logo :)*/
                    success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
                }, 2000);
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });

    </script>

</div>--><!--end: .col-md-10-->

        <div class="col-md-4 col-xs-12">
            <div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-info"></i> Mô tả</div>
            <?php
            TemplateHelper::dt_edit_text(FSText:: _(''), 'summary', @$data->summary, '', 100, 5, 0, '', '', 'col-sm-2', 'col-sm-12');
            ?>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-tags"></i> Tag</div>
            <?php
            TemplateHelper::dt_edit_selectbox('','tags',@$data -> tags,0,$tag,$field_value = 'id', $field_label='name',$size = 30,1,'','','','','','col-sm-12');

            //    TemplateHelper::dt_edit_text(FSText:: _(''), 'tags', @$data->tags, '', 100, 5, 0, '', '', 'col-sm-2', 'col-sm-12');
            ?>
        </div>
    </div>
</div>
<div class="col-md-3" style="background: #e6e6e6; border-radius: 10px;">
    <div id="app">
        <div class="form-group">
            <label class="col-xs-12 control-label">Từ khóa SEO</label>
            <div class="col-xs-12">
                <input type="text" class="form-control" name="seo_main_key" id="seo_main_key" size="60" maxlength="100" v-model="keyword" @input="countLengthKeyword">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label">SEO title</label>
            <div class="col-xs-12">
                <input type="text" class="form-control mb-3" name="seo_title" id="seo_title" size="60" v-model="title">
                <div class="progress">
                    <div class="progress-bar" :class="classTile" role="progressbar"
                         aria-valuemin="0" aria-valuemax="<?php echo MAX_TITLE; ?>" :style="{'width': `${parseInt(width)}%`}">
                        {{ countLengthTitle }}%
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label">SEO meta keyword</label>
            <div class="col-xs-12">
                <input type="text" class="form-control" name="seo_keyword" id="seo_keyword" value="<?php echo @$data->seo_keyword; ?>" size="60" maxlength="100">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label">SEO meta description</label>
            <div class="col-xs-12">
                <textarea class="form-control mb-3" rows="9" cols="60" name="seo_description" id="seo_description" v-model="description"></textarea>
                <div class="progress">
                    <div class="progress-bar" :class="classDes" role="progressbar"
                         aria-valuemin="0" aria-valuemax="<?php echo MAX_DES; ?>" :style="{'width': `${parseInt(widthDes)}%`}">
                        {{ countLengthDescription }}%
                    </div>
                </div>
            </div>
        </div>
        <?php
        TemplateHelper::dt_sepa();
        ?>
        <div class="row" >
            <div class="col-md-12">
                <h3 style="text-align: center;
    background: #fff;
    border-radius: 10px;
    padding: 5px;">Phân tích SEO</h3>
                <ul class="list-check-seo">
                    <li><i class="fa fa-circle mr-2" :class="classTextKey"></i>Độ dài từ khóa (Nên có <?php echo MIN_KEY; ?> - <?php echo MAX_KEY; ?> từ)</li>
                    <li><i class="fa fa-circle mr-2" :class="classTextTitle"></i>Độ dài tiêu đề (Nên dài <?php echo MIN_TITLE; ?> - <?php echo MAX_TITLE; ?> ký tự)</li>
                    <li><i class="fa fa-circle mr-2" :class="classTextDes"></i>Độ dài mô tả (Nên dài <?php echo MIN_DES; ?> - <?php echo MAX_DES; ?> ký tự)</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': checkKey, 'text-danger': !checkKey}"></i>Từ khóa trong tiêu đề chính</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': checkKeyDes, 'text-danger': !checkKeyDes}"></i>Từ khóa trong mô tả</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classWord, 'text-danger': !classWord}"></i><span>Số lượng từ:</span>Nội dung có {{ countWord }} từ (Nên có ít nhất <?php echo MIN_CONTENT; ?> từ)</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classInternal, 'text-danger': !classInternal}"></i><span>Internal Link:</span>Nội dung có {{ countInternalLink }} link nội bộ</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classExternal, 'text-danger': !classExternal}"></i><span>External Link:</span>Nội dung có {{ countExternalLink }} link bên ngoài</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classKeyContent, 'text-danger': !classKeyContent}"></i><span>Từ khóa trong nội dung:</span>Nội dung đã có {{ countKeyContent }} từ khóa</li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classKeyHeading, 'text-danger': !classKeyHeading}"></i><span>Tiêu đề phụ:</span>Tiêu đề phụ có {{ countKeyHeading }} từ khóa</li>
                </ul>
            </div>
        </div>
    </div>
</div>


