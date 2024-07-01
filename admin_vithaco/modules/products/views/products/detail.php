<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css"/>
<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/products.css"/>
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- <script type="importmap">
    {
        "imports": {
            "vue": "https://unpkg.com/vue@3/dist/vue.esm-browser.js"
        }
    }
</script> -->
<script>
    $(document).ready(function () {
        $("#tabs").tabs();
    });
</script>
<?php
$title = @$data ? FSText:: _('Edit') : FSText:: _('Add');

$postLevel = array(
    0 => FSText::_('Thường'),
    1 => FSText::_('Vip'),
    2 => FSText::_('Siêu Vip'),
);

global $toolbar;
$toolbar->setTitle($title);
// $toolbar->addButtonHTML('<a class="update_btn" href="'.URL_ROOT.'index.php?module=api&view=product&task=api_update_price_by_product&id='.@$data->id.'" target="_blank"><i class="fa fa-cloud-download" aria-hidden="true"></i><span>Update Giá</span></a>');
// $toolbar->addButtonHTML('<a class="update_btn" href="'.URL_ROOT.'index.php?module=api&view=product&task=api_add_product&id='.@$data->id.'" ><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Add SP</span></a>');

$toolbar->addButton('getAvailable', "Cập nhật tồn kho", '', 'save.png');
$toolbar->addButton('getDetail', "Cập nhật giá", '', 'save.png');
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');

$this->dt_form_begin(1, 4, @$data->name, 'fa-edit', 1, 'col-md-12', 1);
$category_id = isset($data->category_id) ? $data->category_id : $cid;
define('MIN_TITLE',50);
define('MAX_TITLE',70);
define('MIN_DES',140);
define('MAX_DES',170);
define('MAX_KEY',6);
define('MIN_KEY',3);
define('MIN_CONTENT',900);
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Trường cơ bản"); ?></span></a></li>
        <!-- <li><a href="#fragment-3"><span>--><?php //echo FSText::_("SEO"); ?><!--</span></a></li>-->
        <li><a href="#fragment-7"><span><?php echo FSText::_("Phân loại"); ?></span></a></li>
        <li><a href="#fragment-5"><span><?php echo FSText::_("Ảnh sản phẩm"); ?></span></a></li>
        <li><a href="#fragment-2"><span><?php echo FSText::_("Sản phẩm liên quan "); ?></span></a></li>
        <!-- <li><a href="#fragment-4"><span><?php //echo FSText::_("Phụ kiện mua kèm "); ?></span></a></li> -->
        <!-- <li><a href="#fragment-11"><span><?php //echo FSText::_("Tin liên quan"); ?></span></a></li> -->
        <?php if (isset($extend_fields) && $extend_fields) { ?>
            <li><a href="#fragment-9"><span><?php echo FSText::_("Thông số kỹ thuật"); ?></span></a></li>
        <?php } ?>
        <?php if (isset($extend_fields_new) && !empty($extend_fields_new)) { ?>
            <li><a href="#fragment-10"><span><?php echo FSText::_("Bộ lọc"); ?></span></a></li>
        <?php } ?>
        <!-- <li><a href="#fragment-12"><span><?php //echo FSText::_("Tình trạng hàng cũ"); ?></span></a></li> -->

    </ul>
    
    <div id="fragment-1">
        <?php include_once 'detail_base.php'; ?>
    </div>

    <div id="fragment-7">
        <?php include_once 'detail_color.php'; ?>
    </div>

    <div id="fragment-2">
        <?php include_once 'detail_related.php'; ?>
    </div>

    <div id="fragment-4">
        <?php //include_once 'detail_compatable.php'; ?>
    </div>

    <div id="fragment-11">
        <?php //include_once 'detail_news_related.php'; ?>
    </div>

    <div id="fragment-9">
        <?php if (isset($extend_fields) && $extend_fields) { ?>
            <?php include_once 'detail_extend.php'; ?>
        <?php } ?>
    </div>
    
    <?php if (isset($extend_fields_new) && !empty($extend_fields_new)) { ?>
        <div id="fragment-10">
            <?php include_once 'detail_extend_new.php'; ?>
        </div>
    <?php } ?>

    <div id="fragment-12">
        <?php //include_once 'detail_aspect.php'; ?>
    </div>

    <div id="fragment-5">
        <?php include_once 'detail_images.php'; ?>
    </div>

</div>

<?php
$this->dt_form_end(@$data, 1, 0, 2, 'Cấu hình seo', '', 1);
?>

<div class="modal fade" id="addExtendDetail" data-table="<?php echo str_replace('fs_products_','',$data->tablename) ?>" tabindex="-1" role="dialog" aria-labelledby="addExtendDetailLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                </button>
                <h4 class="modal-title" id="myModalLabel">Chi tiết thông số, phân loại</h4>
            </div>
            <div class="modal-body">
                <form id="list_detail" name="list_detail" method="post">

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeAccents(str) {
        var AccentsMap = [
            "aàảãáạăằẳẵắặâầẩẫấậ",
            "AÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬ",
            "dđ", "DĐ",
            "eèẻẽéẹêềểễếệ",
            "EÈẺẼÉẸÊỀỂỄẾỆ",
            "iìỉĩíị",
            "IÌỈĨÍỊ",
            "oòỏõóọôồổỗốộơờởỡớợ",
            "OÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢ",
            "uùủũúụưừửữứự",
            "UÙỦŨÚỤƯỪỬỮỨỰ",
            "yỳỷỹýỵ",
            "YỲỶỸÝỴ"
        ];
        for (var i=0; i<AccentsMap.length; i++) {
            var re = new RegExp('[' + AccentsMap[i].substr(1) + ']', 'g');
            var char = AccentsMap[i][0];
            str = str.replace(re, char);
        }
        return str;
    }
</script>
<!-- 
<script type="module">
    const regex = /(<([^>]+)>)/ig; // remove tag html
    const regex_space = /\S+/g; // remove backspace
    const regex_tag_heading = /(?<=(?!h1|h2|h3|h4|h5|h6)\>)(?!\<)(.+?)(?=\<\/.+?(?=h1|h2|h3|h4|h5|h6))/g; // remove tag heading

    var count_word = ($('#description').val().length > 0)?$('#description').val().replace(regex, "").match(regex_space || [] ).length:0;
    var count_internal_link = ($('#description').val().match(new RegExp('<?php echo $_SERVER['HTTP_HOST']; ?>', "gi")))?$('#description').val().match(new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>", "gi") || []).length:0;
    var external_link = ($('#description').val().match(/href="(.*?)"/gi || []))?$('#description').val().match(/href="(.*?)"/gi || []):null;
    var count_external_link = 0;
    if (external_link){
        for (let i = 0; i < external_link.length; i++) {
            if (!external_link[i].includes('<?php echo $_SERVER['HTTP_HOST']; ?>')) {
                count_external_link ++;
            }
        }
    }

    import { createApp } from 'vue'
    var app = createApp({
        data() {
            return {
                keyword: '<?php echo @$data->seo_main_key; ?>',
                title: '<?php echo @$data->seo_title; ?>',
                width: 0,
                description: '<?php echo @$data->seo_description; ?>',
                widthDes: 0,
                classTile: 'progress-bar-danger',
                classDes: 'progress-bar-danger',
                classTextDes: 'text-danger',
                classTextTitle: 'text-danger',
                classTextKey: 'text-danger',
                checkKey: false,
                checkKeyDes: false,
                checkKeyUrl: false,
                countWord: count_word,
                classWord: false,
                internalLink: '<?php echo $_SERVER['HTTP_HOST']; ?>',
                countInternalLink: count_internal_link,
                classInternal: false,
                countExternalLink: count_external_link,
                classExternal: false,
                countKeyContent: 0,
                classKeyContent: false,
                countKeyHeading: 0,
                classKeyHeading: false
            }
        },
        mounted() {
            self = this
            if (self.countWord >= 900){
                self.classWord = true
            }else {
                self.classWord = false
            }

            if (count_internal_link){
                self.classInternal = true
            }else {
                self.classInternal = false
            }

            if (count_external_link){
                self.classExternal = true
            }else {
                self.classExternal = false
            }
            if (this.keyword){
                self.countKeyContent = ($('#description').val().match(new RegExp(this.keyword, "gi")).length)?$('#description').val().match(new RegExp(this.keyword, "gi") || []).length:0;
                if(self.countKeyContent){
                    self.classKeyContent = true
                }else {
                    self.classKeyContent = false
                }
            }

            CKEDITOR.instances.content.on( 'change', function( evt ) {
                let html =  evt.editor.getData();
                let str =  html.replace(regex, "");
                if (str.length > 0){
                    let count_srt = str.match(regex_space).length;
                    self.countWord = count_srt
                    if (self.countWord >= <?php echo MIN_CONTENT; ?>){
                        self.classWord = true
                    }else {
                        self.classWord = false
                    }
                    if (self.keyword){
                        if (html.match(regex_tag_heading)){
                            let countHeading = (html.match(regex_tag_heading));
                            if (countHeading){
                                let countKeyInHeading = 0;
                                for (let i = 0; i < countHeading.length; i++) {
                                    if (countHeading[i].includes(self.keyword)) {
                                        countKeyInHeading ++;
                                    }
                                }
                                self.countKeyHeading = countKeyInHeading;
                                self.classKeyHeading = true
                            }else {
                                self.countKeyHeading = 0;
                                self.classKeyHeading = false
                            }
                        }

                        let countKeyInContent = (html.match(new RegExp(self.keyword, "gi")) || []).length;
                        if (countKeyInContent){
                            self.countKeyContent = countKeyInContent;
                            self.classKeyContent = true
                        }else {
                            self.countKeyContent = 0;
                            self.classKeyContent = false
                        }
                    }

                    let countInternalLinkInContent = (html.match(new RegExp(self.internalLink, "gi")) || []).length;
                    if (countInternalLinkInContent){
                        self.countInternalLink = countInternalLinkInContent;
                        self.classInternal = true;
                    }else {
                        self.classInternal = false;
                    }

                    let externalLinkInContent = (html.match(/href="(.*?)"/gi || []))?html.match(/href="(.*?)"/gi):null;
                    let countExternalLinkInContent = 0;
                    if (externalLinkInContent){
                        for (let i = 0; i < externalLinkInContent.length; i++) {
                            if (!externalLinkInContent[i].includes('<?php echo $_SERVER['HTTP_HOST']; ?>')) {
                                countExternalLinkInContent ++;
                            }
                        }
                        self.classExternal = true;
                        self.countExternalLink = countExternalLinkInContent;
                    }else {
                        self.countExternalLink = 0;
                        self.classExternal = false;
                    }
                }
            });
        },
        methods: {
            countLengthKeyword() {
                let str = this.keyword;
                var arr = 0;
                if (str.length > 0){
                    arr = str.match(regex_space).length;
                }
                if(arr >= <?php echo MIN_KEY; ?> && arr <= <?php echo MAX_KEY; ?>){
                    this.classTextKey = 'text-success'
                }else if (arr > <?php echo MAX_KEY; ?>) {
                    this.classTextKey = 'text-warning'
                }else {
                    this.classTextKey = 'text-danger'
                }
            },
        },
        computed: {
            countLengthKeyword() {
                let str = this.keyword;
                var arr = 0;
                if (str.length > 0){
                    arr = str.match(regex_space).length;
                }
                if(arr >= <?php echo MIN_KEY; ?> && arr <= <?php echo MAX_KEY; ?>){
                    this.classTextKey = 'text-success'
                }else if (arr > <?php echo MAX_KEY; ?>) {
                    this.classTextKey = 'text-warning'
                }else {
                    this.classTextKey = 'text-danger'
                }
            },
            countLengthTitle() {
                let str = this.title.length;
                if (this.keyword.length >= 2){
                    this.checkKey = this.title.includes(this.keyword);
                }

                this.width = (str/<?php echo MAX_TITLE; ?>)*100
                if(this.width >= 50 && this.width <= 70){
                    this.classTile = 'progress-bar-success'
                    this.classTextTitle = 'text-success'
                }else if (this.width > 100) {
                    this.classTile = 'progress-bar-warning'
                    this.classTextTitle = 'text-warning'
                }else {
                    this.classTile = 'progress-bar-danger'
                    this.classTextTitle = 'text-danger'
                }
                return parseInt(this.width);
            },
            countLengthDescription() {
                let str = this.description.length;
                if (this.keyword.length >= 2){
                    this.checkKeyDes = this.description.includes(this.keyword);
                }
                this.widthDes = (str/<?php echo MAX_DES; ?>)*100
                if(this.widthDes >= 140 && this.widthDes <= 170){
                    this.classDes = 'progress-bar-success',
                        this.classTextDes = 'text-success'
                }else if (this.widthDes > 170) {
                    this.classDes = 'progress-bar-warning',
                        this.classTextDes = 'text-warning'
                }else {
                    this.classDes = 'progress-bar-danger',
                        this.classTextDes = 'text-danger'
                }
                return parseInt(this.widthDes);
            },
        }
    });

    app.mount('#app')
</script> -->

<style>
    .mb-3 {
        margin-bottom: 10px;
    }
    .mr-2{
        margin-right: 5px;
    }
    .list-check-seo{
        padding: 0;
    }
    .list-check-seo li{
        list-style: none;
        min-height: 28px;
        padding: 5px;
    }
    .list-check-seo li:nth-child(odd){
        background: #f3fcff;
    }
    .list-check-seo li span{
        color: #0a90eb;
        margin-right: 4px;
    }
</style>
