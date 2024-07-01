<table cellspacing="1" class="admintable">
    <?php
    $this->dt_form_begin(1, 2, FSText::_('Ảnh theo phân loại'), 'fa-photo', 1,
        'col-md-12');
    TemplateHelper::dt_edit_image2(FSText::_('Ảnh khác'), 'image',
        str_replace('/original/', '/resized/', URL_ROOT . @$data->image), '',
        '', '', 1, '', 'col-md-12', 'col-md-12', 0);
    $this->dt_form_end_col();

    //điểm nổi bật
    $this->dt_form_begin(1, 2, FSText::_('Điểm nổi bật'), 'fa-photo', 1,
        'col-md-12');

    if (isset($data->id) && $data->id) {
        $uploadConfig3d = base64_encode('edit|' . $data->id);
    } else {
        $uploadConfig3d = base64_encode('add|' . session_id());
    }
    $images_3d = TemplateHelper::get_other_images('products',
        $uploadConfig3d, 1);

    $arr_sku_map = array();
    $i = 0;
    foreach ($images_3d as $item) {
        $arr_sku_map['Data'][$i]['AttachmentID'] = $item->id;
        $arr_sku_map['Data'][$i]['Path'] = URL_ROOT . str_replace('/original/',
                '/original/', $item->image);
        $i++;
    }
    $skuConfig = json_encode($arr_sku_map);
    ?>
    <script>
        $(function () {
            $("#previews_3d").sortable({
                update: function () {
                    serial = $("#previews_3d").sortable("serialize");
                    $.ajax({
                        url: "index2.php?module=products&view=products&raw=1&task=sort_other_images",
                        type: "post",
                        data: serial,
                        error: function () {
                            alert("Lỗi load dữ liệu");
                        }
                    });

                }
            });

        });
        $(document).ready(function () {
            Dropzone.autoDiscover = false;
            let data = '<?php echo $skuConfig; ?>';
            let previewNode = document.querySelector("#template_3d");
            let uploadConfig3d = $("#uploadConfig3d").val();
            previewNode.id = "";
            let previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);

            let myDropzone2 = new Dropzone("div#fragment-5", {// Make the whole body a dropzone
                url: "index2.php?module=products&view=products&raw=1&task=upload_other_images&data=" + uploadConfig3d + "&type_img=1",
                thumbnailWidth: 100,
                thumbnailHeight: 100,
                parallelUploads: 20,
                previewTemplate: previewTemplate,
                autoQueue: true,
                previewsContainer: "#previews_3d",
                clickable: ".fileinput-button-3d",
                removedfile: function (file) {

                    let record_id = $("#id_mage_3d").val();
                    $.ajax({
                        type: "POST",
                        url: "index2.php?module=products&view=products&raw=1&task=delete_other_image",
                        data: {
                            "name": file.name,
                            "record_id": record_id,
                            "id": file.size
                        }
                    });
                    let _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                init: function () {
                    data = JSON.parse(data);
                    let thisDropzone = this;
                    if (data.Data != null) {
                        $.each(data.Data, function (index, item) {
                            let mockFile = {
                                name: item.FileName,
                                size: item.AttachmentID,
                                ColorId: item.ColorId,
                                size_id: item.size_id,
                            };
                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.emit("thumbnail", mockFile, item.Path);
                            thisDropzone.emit("complete", mockFile);
                            $(mockFile.previewElement).prop("id", "sort_" + item.AttachmentID);
                            $(mockFile.previewTemplate).find('#save').attr("data-id", item.AttachmentID);
                        });
                    }
                    this.on("success", function (file, response) {
                        response = JSON.parse(response);
                        file.previewElement.id = "sort_" + response.id;
                    });
                }
            });


        });
    </script>

    <input type="hidden" name="session_id" id="session_id" value="<?php
    $data2 = base64_decode($uploadConfig3d);
    $data2 = explode('|', $data2);
    echo $data2[1];
    ?>"/>
    <div class="dropzone files cf" id="previews_3d">
        <div id="template_3d" class="dz-preview dz-image-preview">
            <div class="dz-details">
                <img data-dz-thumbnail/>
            </div>
            <div class="dz-progress"><span class="dz-upload"
                                           data-dz-uploadprogress=""></span>
            </div>
            <a class="dz-remove" data-dz-remove id="">Remove</a>
        </div>
    </div>
    <input type="hidden" value="<?php echo $uploadConfig3d; ?>"
           id="uploadConfig3d"/>
    <input type="hidden" value="<?php echo $id; ?>" id="id_mage_3d"/>
    <span class="post_images fileinput-button-3d">Thêm ảnh/video</span>
    <?php
    $this->dt_form_end_col();

    //ảnh từ camera
    $this->dt_form_begin(1, 2, FSText::_('Ảnh từ camera'), 'fa-photo', 1,
        'col-md-12');

    if (isset($data->id) && $data->id) {
        $uploadConfigcamera = base64_encode('edit|' . $data->id);
    } else {
        $uploadConfigcamera = base64_encode('add|' . session_id());
    }
    $images_camera = TemplateHelper::get_other_images('products',
        $uploadConfigcamera, 2);

    $arr_sku_map = array();
    $i = 0;
    foreach ($images_camera as $item) {
        $arr_sku_map['Data'][$i]['AttachmentID'] = $item->id;
        $arr_sku_map['Data'][$i]['Path'] = URL_ROOT . str_replace('/original/',
                '/original/', $item->image);
        $i++;
    }
    $skuConfig = json_encode($arr_sku_map);
    ?>
    <script>
        $(function () {
            $("#previews_camera").sortable({
                update: function () {
                    serial = $("#previews_camera").sortable("serialize");
                    $.ajax({
                        url: "index2.php?module=products&view=products&raw=1&task=sort_other_images",
                        type: "post",
                        data: serial,
                        error: function () {
                            alert("Lỗi load dữ liệu");
                        }
                    });

                }
            });

        });
        $(document).ready(function () {
            Dropzone.autoDiscover = false;
            let data = '<?php echo $skuConfig; ?>';
            let previewNode = document.querySelector("#template_camera");
            let uploadConfigcamera = $("#uploadConfigcamera").val();
            previewNode.id = "";
            let previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);

            let myDropzone3 = new Dropzone("div#camera_img", {// Make the whole body a dropzone
                url: "index2.php?module=products&view=products&raw=1&task=upload_other_images&data=" + uploadConfigcamera + "&type_img=2",
                thumbnailWidth: 100,
                thumbnailHeight: 100,
                parallelUploads: 20,
                previewTemplate: previewTemplate,
                autoQueue: true,
                previewsContainer: "#previews_camera",
                clickable: ".fileinput-button-camera",
                removedfile: function (file) {

                    let record_id = $("#id_mage_camera").val();
                    $.ajax({
                        type: "POST",
                        url: "index2.php?module=products&view=products&raw=1&task=delete_other_image",
                        data: {
                            "name": file.name,
                            "record_id": record_id,
                            "id": file.size
                        }
                    });
                    let _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                init: function () {
                    data = JSON.parse(data);
                    let thisDropzone = this;
                    if (data.Data != null) {
                        $.each(data.Data, function (index, item) {
                            let mockFile = {
                                name: item.FileName,
                                size: item.AttachmentID,
                                ColorId: item.ColorId,
                                size_id: item.size_id,
                            };
                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.emit("thumbnail", mockFile, item.Path);
                            thisDropzone.emit("complete", mockFile);
                            $(mockFile.previewElement).prop("id", "sort_" + item.AttachmentID);
                            $(mockFile.previewTemplate).find('#save').attr("data-id", item.AttachmentID);
                        });
                    }
                    this.on("success", function (file, response) {
                        response = JSON.parse(response);
                        file.previewElement.id = "sort_" + response.id;
                    });
                }
            });


        });
    </script>
    <div id="camera_img">
        <input type="hidden" name="session_id" id="session_id" value="<?php
        $data3 = base64_decode($uploadConfigcamera);
        $data3 = explode('|', $data3);
        echo $data3[1];
        ?>"/>
        <div class="dropzone files cf" id="previews_camera">
            <div id="template_camera" class="dz-preview dz-image-preview">
                <div class="dz-details">
                    <img data-dz-thumbnail/>
                </div>
                <div class="dz-progress"><span class="dz-upload"
                                               data-dz-uploadprogress=""></span>
                </div>
                <a class="dz-remove" data-dz-remove id="">Remove</a>
            </div>
        </div>
        <input type="hidden" value="<?php echo $uploadConfigcamera; ?>"
               id="uploadConfigcamera"/>
        <input type="hidden" value="<?php echo $id; ?>" id="id_mage_camera"/>
        <span class="post_images fileinput-button-camera">Thêm ảnh/video</span>
    </div>
    <?php
    $this->dt_form_end_col();
    ?>
</table>
