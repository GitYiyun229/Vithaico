<?
function template_top($title='',$help=1){
	include("modules/login/template/config.php");
	global $module_id;
?>
<? /**********------------------- Begin Template V3 - Do not Modify -------------------**********/ ?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<? /*****----- HEADER here -----*****/ ?>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr height="<?=$dt_mid_top_height;?>">
					<? /*** Left _ top ***/ ?>
					<td width="<?=$dt_left_top_width;?>"><img src="<?=$dt_left_top_picture;?>"/></td>
					<? /*** Mid _ top - insert Title here ***/ ?>
					<td background="<?=$dt_mid_top_background;?>">
			<? /*---------- Title start here ----------*/ ?>
			
						<div class="form_title"><?=$title?></div>
			
			<? /*---------- Title end here ----------*/ ?>
					</td>
			<?
			if($help == 1){
			?>
					<td background="<?=$dt_mid_top_background;?>" align="right">
			<? /*---------- Title start here ----------*/ ?>
			
						<div class="form_title"><a href="../help/detail.php?iMod=<?=$module_id?>&url=<?=base64_encode($_SERVER['SCRIPT_NAME'] . '?' . @$_SERVER['QUERY_STRING'])?>"><img src="../images/help.gif" border="0" align="absmiddle" /> &nbsp; Xem huong dan su dung</a></div>
			<? /*---------- Title end here ----------*/ ?>
					</td>
			<?
			}
			?>
					<? /*** Right _ top ***/ ?>
					<td width="<?=$dt_right_top_width;?>"><img src="<?=$dt_right_top_picture;?>"/></td>
				</tr>
			</table>
			<? /*****----- End HEADER here -----*****/ ?>
			<? /*****----- BODY Here-----*****/ ?>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<? /*** left _ mid ***/ ?>
					<td width="<?=$dt_left_mid_width;?>" background="<?=$dt_left_mid_background;?>"><img src="<?=$dt_left_mid_background;?>" /></td>
					<td align="center" bgcolor="<?=$dt_mid_mid_backcolor;?>">
<? /*----------..................... Start WEB CONTENT here ....................----------*/ ?>
<?
}
?>
<?
function template_bottom(){
	global $module_id;
	include("modules/login/template/config.php");
?>
<? /*----------...................... End WEB CONTENT here .....................----------*/ ?>
					</td>
					<td width="<?=$dt_right_mid_width;?>" background="<?=$dt_right_mid_background;?>"><img src="<?=$dt_right_mid_background;?>" /></td>
				</tr>
			</table>
			<? /*****----- End BODY here -----*****/ ?>
			<? /*****----- FOOTER here -----*****/ ?>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr height="<?=$dt_mid_bottom_height;?>">
					<? /*** Left _ bottom ***/ ?>
					<td width="<?=$dt_left_bottom_width;?>"><img src="<?=$dt_left_bottom_picture;?>"/></td>
					<? /*** Mid _ bottom ***/ ?>
					<td background="<?=$dt_mid_bottom_background;?>"><img src="<?=$dt_mid_bottom_background;?>"/></td>
					<? /*** Right _ bottom ***/ ?>
					<td width="<?=$dt_right_bottom_width;?>"><img src="<?=$dt_right_bottom_picture;?>"/></td>
				</tr>
			</table>
			<? /*****----- End FOOTER here -----*****/ ?>
		</td>
	</tr>
</table>
<?
if($module_id !=0){
?>
<script language="javascript" type="text/javascript">function SwitchLeftFrame(){    if(typeof(top.GetBarExpanded)!="undefined"){        ExpandLeftFrame(!top.GetBarExpanded());    }}function ExpandLeftFrame(f) {    var i=document.getElementById("imgLeftFrameSwitcher");    if(i){        i.src="../css/bar_"+(f?"close":"open")+".gif";        top.FoldFrame(f);    }}function SetExpandLeftFrame(){    if(typeof(top.GetBarExpanded)!="undefined"){        ExpandLeftFrame(top.GetBarExpanded());    }}</script><div class="LeftFrameSwitcher" id="divLeftFrameSwitcher"><img alt="bar_close.gif" title="Hide/show the navigation pane" id="imgLeftFrameSwitcher" onClick="SwitchLeftFrame();" style="cursor:pointer" src="../css/bar_close.gif" height="60" width="6">
<?
}
?>
<? /**********------------------- End Template V3 - Do not Modify -------------------**********/ ?>
<?
}
?>