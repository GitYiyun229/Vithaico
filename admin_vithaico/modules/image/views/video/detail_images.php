<?php 
    //global $config; 
?>
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php $style = @$data->top && @$data->pos_left? 'style="top:'.@$data->top.'px;left:'.@$data->pos_left.'px;"':'' ?>
<p class="help-block"><?php echo FSText::_('Kéo icon đến vị trí bạn muốn'); ?></p>
<article id="pos-images" class="pos-images">
    <a class="w3-btn" href="#login-box" <?php echo $style;  ?> >
        <i class="fa fa-play-circle"></i>
        <?php echo @$data->name? @$data->name:FSText::_('Name') ?>
    </a>
</article><!-- END: pos-images -->
<style>
    article {
        background: rgba(0, 0, 0, 0) url('<?php echo URL_ROOT.$config['images_map_video'] ?>') no-repeat scroll center center;
        min-height: 547px;
        position: relative;
        width: 600px;
        margin: 0 auto;
    }
    .w3-btn, .w3-btn-block {
        border: none;
        display: inline-block;
        outline: 0;
        padding: 6px 16px;
        vertical-align: middle;
        overflow: hidden;
        text-decoration: none !important;
        color: #fff;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        white-space: nowrap;
        color: #ffffff !important;
    }
    .w3-btn {
        background: #8B5D1F;
        border-radius: 14px;
        padding: 1px 7px 1px 4px;
        position: absolute;
    }
</style>
<script>

$(document).ready(function() {
    $(".w3-btn").draggable({ 
                containment: '#pos-images', 
                scroll: false
         }).mousemove(function(){
                var coord = $(this).position();
                $('#top').val(coord.top);
                $('#pos_left').val(coord.left);
                //$('.w3-btn').css({"top": coord.left, "left": coord.top});    
                //$("p.position").text( "(" + coord.left + "," + coord.top + ")" );
                //$("p.size").text( "(" + width + "," + height + ")" );
         }).mouseup(function(){
                var coord = $(this).position();
                $('#top').val(coord.top);
                $('#pos_left').val(coord.left);
        });
});


</script>