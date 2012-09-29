	</div>
</header>
<div id="pagetitle">
</div>
<div id="page">
	<div class="wrapper">
	<section class="column width5 first">
		<div class='clear'>&nbsp;</div>
		<script type="text/javascript">
			$(function(){
				$("#KinSlideshow").KinSlideshow({
					intervalTime:"3",
	                moveStyle:"right",
	                titleBar:{titleBar_height:30,titleBar_bgColor:"#08355c",titleBar_alpha:0.5},
	                titleFont:{TitleFont_size:12,TitleFont_color:"#FFFFFF",TitleFont_weight:"normal"},
	                btn:{btn_bgColor:"#FFFFFF",btn_bgHoverColor:"#1072aa",btn_fontColor:"#000000",
	                     btn_fontHoverColor:"#FFFFFF",btn_borderColor:"#cccccc",
	                     btn_borderHoverColor:"#1188c0",btn_borderWidth:1}
				});
			})
		</script>
		<div id="KinSlideshow" style="visibility:hidden;">
      		<a href="#" target="_blank"><img src='../../../images/1.jpg' width="600" height="300" alt="这是标题一" /></a>
      		<a href="#" target="_blank"><img src="../../../images/2.jpg" width="600" height="300" alt="这是标题二" /></a>
      		<a href="#" target="_blank"><img src="../../../images/3.jpg" width="600" height="300" alt="这是标题三" /></a>
      		<a href="#" target="_blank"><img src="../../../images/4.jpg" width="600" height="300" alt="这是标题四" /></a>
  		</div>
	</section>
	<aside class="column width3">
		<h3>Login</h3>
		<div class="box box-info">Type anything to log in</div>
		<form name='loginform' id='loginform' method='post' action='<?php echo $this->createUrl("admin/authentication/login"); ?>' class='ym-form'>
		    <!-- 
		    <p><strong><?php echo $summary; ?></strong><br /><br /></p>
		     -->
		    <!-- username input part -->
		    <p>
		    	<label for='user'><?php $clang->eT("Username"); ?></label><br/>
		        <input name='user' id='user' type='text' class='full title' size='40' maxlength='40' value='' tabindex="1" required="required" />
		    </p>
		    
		    <!-- password input part -->
		    <p>
		        <label for='password'><?php $clang->eT("Password"); ?></label><br/>
		        <input name='password' id='password' type='password' class='full title' size='40' maxlength='40' tabindex='2' required='required' />
		            
			</p>
			<!-- language setting selected part -->
			<p>
		        <label for='loginlang'><?php $clang->eT("Language"); ?></label><br/>
		        <select id='loginlang' name='loginlang' class='full'>
		                <option value="default" selected="selected"><?php $clang->eT('Default'); ?></option>
		                <?php
		                $x = 0;
		                foreach (getLanguageDataRestricted(true) as $sLangKey => $aLanguage)
		                {
		                    //The following conditional statements select the browser language in the language drop down box and echoes the other options.
		                    ?>
		                    <option value='<?php echo $sLangKey; ?>'><?php echo $aLanguage['nativedescription'] . " - " . $aLanguage['description']; ?></option>
		                    <?php
		                }
		                ?>
		         </select>
		    </p>
		   	<p>
		   		<input type='hidden' name='action' value='login' />
		       	<input type='submit' class='btn btn-green' value='<?php $clang->eT("Login"); ?>' class='ym-button' tabindex='3'/>&nbsp;
		       	<?php
		        if (Yii::app()->getConfig("display_user_password_in_email") === true)
		        {
		            ?>
		            <a tabindex='4' href='<?php echo $this->createUrl("admin/authentication/forgotpassword"); ?>'><?php $clang->eT("Forgot your password?"); ?></a>
		            <?php
		        }
		        ?>
		    </p>
		    <div class="clear">&nbsp;</div>
		</form>
	</aside>
<script type='text/javascript'>
    document.getElementById('user').focus();
</script>