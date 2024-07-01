<?php
  global $tmpl;
  $tmpl -> addStylesheet("users_info","modules/users/assets/css");
?>
<script src="<?php echo URL_ROOT.'modules/users/assets/js/users_changepass.js'; ?>" type="text/javascript" language="javascript" ></script>
<div id="register-form" class ="frame_large" >
    

	<h2 class="infor_title">Đổi mật khẩu</h2>
    <div class="frame_large_body">
            <!--   FRAME COLOR        -->
            <div class='frame_color user_register' >
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                    
                     <!--  CONTENT IN FRAME      -->
                     
					<form action="<?php echo FSRoute::_("index.php?module=users&task=edit_save_changepass");?>" onsubmit="javascript:return checkFormsubmit();" name="frm_repassword_gh" method="post" id="frm_repassword_gh">
						<div>
							<div  class="tr-001">
								<span colspan="2"> Nh&#7919;ng tr&#432;&#7901;ng c&#243; d&#7845;u (<font color="red">*</font>) l&#224; b&#7855;t bu&#7897;c ph&#7843;i nh&#7853;p
								</span>
							</div>
							<div  class="tr-001">
								<span class="infor_users">Username :</span>
								<input class="infor_input" type="text" name="username"  id="username" value="<?php echo $_SESSION['username']; ?>" disabled="disabled" />
							</div>
							<div  class="tr-001">
								<span class="infor_users">Nhập mật khẩu cũ (<font color="red">*</font>) :
								</span>
								<input class="infor_input" type="password" name="text_pass_old" id="text_pass_old" value=""/>
							</div>
							<div  class="tr-001">
								<span class="infor_users">Nhập mật khẩu mới (<font color="red">*</font>):
								</span>
								<input class="infor_input" type="password" name="text_pass_new" id="text_pass_new"  value=""/><font color="gray" class="font_charcter"> ( Ít nhất 6 kí tự )</font>
							</div>
							<div  class="tr-001">
								<span class="infor_users">Nhập lại mật khẩu mới (<font color="red">*</font>):</span>
								<input class="infor_input" type="password" name="text_re_pass_new" id="text_re_pass_new" value="" />
							</div>
							  	
							<input type="submit" value="<?php echo FSText::_("Lưu thay đổi"); ?>" name="submitbt" id="submitbt"  class='button-submit-edits'/>									
							
						</div>
						<input type="hidden" name = "module" value = "users" />
						<input type="hidden" name = "task" value = "edit_save_changepass" />
						<input type="hidden" name = "Itemid" value = "<?php echo FSInput::get('Itemid');?>" />
				</form>
			<!--	FORM			-->
			  </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
            <!--   end FRAME COLOR        -->
                   
           <!--   end SUBMIT REGISTER        -->
        
    </div>
    <div class="frame_large_footer">
        <div class="frame_large_footer_l">&nbsp;</div>
        <div class="frame_large_footer_r">&nbsp;</div>
    </div>
</div>    

