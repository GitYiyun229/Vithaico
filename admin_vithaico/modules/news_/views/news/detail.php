<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css"/>
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<script type="importmap">
      {
        "imports": {
          "vue": "https://unpkg.com/vue@3/dist/vue.esm-browser.js"
        }
      }
    </script>
<script>
    $(document).ready(function() {
        $("#tabs").tabs();
    });
</script>
<style>
    .ui-tabs .ui-tabs-nav{
        margin-bottom: 20px;
    }
</style>
<?php
$title = @$data ? FSText:: _('Edit') : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png', 1);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png', 1);
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');
echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';
$this->dt_form_begin(1, 4,'', 'fa-edit', 1, 'col-md-12', 1);
define('MIN_TITLE',60);
define('MAX_TITLE',100);
define('MIN_DES',100);
define('MAX_DES',200);
define('MAX_KEY',6);
define('MIN_KEY',3);
define('MIN_CONTENT',900);
?>
<div id="tabs" class="row">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Trường cơ bản"); ?></span></a></li>
        <li><a href="#fragment-2"><span><?php echo FSText::_("Tin liên quan"); ?></span></a></li>
        <li><a href="#fragment-4"><span><?php echo FSText::_("Hỏi đáp"); ?></span></a></li>
<!--        <li><a href="#fragment-3"><span>--><?php //echo FSText::_("Cấu hình SEO"); ?><!--</span></a></li>-->
    </ul>
    <div id="fragment-1" style="padding: 0">
        <?php
        include_once 'detail_base.php';
        ?>
    </div>
    <div id="fragment-2" style="padding: 0">
        <?php include_once 'detail_related.php';?>
    </div>
<!--    <div id="fragment-3" style="padding: 0">-->
<!--        --><?php //include_once 'detail_seo.php';?>
<!--    </div>-->
    <div id="fragment-4" style="padding: 0">
        <?php include_once 'detail_faq.php';?>
    </div>
</div>
<?php
$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator() {
        $('.alert-danger').show();

        if (!notEmpty('title', 'Bạn phải nhập tiêu đề'))
            return false;

//        if(!notEmpty('image','bạn phải nhập hình ảnh'))
//			return false;

        // if(!notEmpty('category_id','Bạn phải chọn danh mục'))
        //   return false;

        if (!notEmpty('summary', 'Bạn phải nhập nội dung mô tả'))
            return false;

        if (CKEDITOR.instances.content.getData() == '') {
            invalid("content", 'Bạn phải nhập nội dung chi tiết');
            return false;
        }

        $('.alert-danger').hide();
        return true;
    }
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
<?php //include 'detail_seo.php'; ?>
<script type="module">

    const regex = /(<([^>]+)>)/ig; // remove tag html
    const regex_space = /\S+/g; // remove backspace
    const regex_tag_heading = /(?<=(?!h1|h2|h3|h4|h5|h6)\>)(?!\<)(.+?)(?=\<\/.+?(?=h1|h2|h3|h4|h5|h6))/g; // remove tag heading

    var count_word = ($('#content').val().length > 0)?$('#content').val().replace(regex, "").match(regex_space || [] ).length:0;
    var count_internal_link = ($('#content').val().match(new RegExp('<?php echo $_SERVER['HTTP_HOST']; ?>', "gi")))?$('#content').val().match(new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>", "gi") || []).length:0;
    var external_link = ($('#content').val().match(/href="(.*?)"/gi || []))?$('#content').val().match(/href="(.*?)"/gi || []):null;
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
                keyword: '<?php echo @$data->seo_main_key ?>',
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
                self.countKeyContent = ($('#content').val().match(new RegExp(this.keyword, "gi")).length)?$('#content').val().match(new RegExp(this.keyword, "gi") || []).length:0;
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
    })

    app.mount('#app')

</script>
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
