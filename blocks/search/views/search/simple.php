<?php 
global $tmpl;
// $tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery.ui');
// $tmpl -> addScript("jquery-ui","libraries/jquery/jquery.ui");
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
$tmpl -> addStylesheet('search_simple','blocks/search/assets/css');
$tmpl -> addScript("search_simple","blocks/search/assets/js");

$link = FSRoute::_('index.php?module=products&view=search');
?>
<?php 
    $text_default = FSText::_('');
    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'products'){
        $key = FSInput::get('keyword');
        if($key){
            $keyword = $key;
        }
    }
?>
<div id="search_simple" class="search_simple">
	<div class="search_simple_content">
        <form action="<?php echo $link; ?>" name="search_form" id="search_form_simple" method="get" onsubmit="javascript: submit_form_search();return false;" >
            <input type="text" value="<?php echo $keyword; ?>"  placeholder="Rẻ mà bền..." id="keyword_simple" name="keyword_simple" class="keyword_simple input-text" />
            <input type="hidden" class="button-search  searchbt_simple" id='searchbt_simple' value="" />
            <input type='hidden'  id='link_search_simple' value="<?php echo $link; ?>" />
        </form>
	</div>
</div>