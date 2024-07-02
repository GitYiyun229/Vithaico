<?php 
    global $tmpl;
    $tmpl->setTitle("Trang quản trị");
    $tmpl -> addStylesheet("users_logged","modules/users/assets/css");
    $Itemid = FSInput::get('Itemid',1);
    $redirect = FSInput::get('redirect');
    
?>  
<div id="login-form" class ="frame_large" >
    <div class="frame_auto_head">
		<div class="frame_auto_head_l">
			<h1>Trang quản trị</h1>
		</div>
		<div class="frame_auto_head_inner"></div>
		<div class="frame_auto_head_r"></div>
	</div>
    <div class="frame_auto_body">
           
            <!--   FRAME COLOR        -->
            <div class='frame_color'>
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                        Chào mừng các bạn đã đăng nhập vào hệ thống.
                    
                   <!--  end CONTENT IN FRAME      -->
           
                    </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
            <!--   end FRAME COLOR        -->
            
           
           
        
    </div>
    <div class="frame_auto_footer">
		<div class="frame_footer_left">&nbsp;</div>
		<div class="frame_footer_right">&nbsp;</div>
	</div>
</div>    
        
        