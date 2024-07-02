<?php 
global $tmpl;

//$tmpl -> addScript('product_images_carousel','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_carousel','modules/products/assets/css');
$i=0;$j=0;
$cols=4;
$array1 = array("0" => $product);
//var_dump($array1);
//var_dump($product_images);
$result = array_merge($array1, $product_images);
//var_dump($result);
$total =count($result);
if($total){

?>

    <div class="slide-image row-item">

        <ul id="imageGallery" >
            <?php if (!$product_images) {?>
            <li  data-color= "color_rm" data-thumb="<?php echo URL_ROOT.str_replace('/original/', '/small/', $data -> image)?>" data-src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $data -> image)?>">
                <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/large/', $data -> image)?>" alt="<?php echo @$data->alt ?>" title="<?php echo @$data->title ?>" />
            </li>
        <?php } ?>
            <?php foreach($product_images as $item){?>
                <?php if($item->image){ ?>
                    <li class="color_hide color_rm color-<?php echo $item->color_id;?>" data-color="color_rm color-<?php echo $item->color_id;?>" data-thumb="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item -> image)?>" data-src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $item -> image)?>">
                        <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/large/', $item -> image)?>" alt="<?php echo @$item->alt ?>" title="<?php echo @$item->title ?>" />
                    </li>
                <?php } ?>
            <?php }?>
        </ul>
    </div>
<?php }?>