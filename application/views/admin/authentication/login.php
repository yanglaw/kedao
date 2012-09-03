		</div>
	</div>
	</header>
	<div id="main">
		<div class="ym-wrapper">
			<div class="ym-wbox">
				<div class="ym-column linearize-level-1">
					<div class="ym-g66 ym-gl content">
						<div class="ym-gbox-left ym-clearfix">
							<section class="box info">
								<div>
									<h2>Main Content</h2>
								</div>
	<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
	<a class="ym-button ym-next" href="#">Read More</a>
							</section>
						</div>
					</div>
					<aside class="ym-g33 ym-gr">
						<div class="ym-gbox-right ym-clearfix">
						<form name='loginform' id='loginform' method='post' action='<?php echo $this->createUrl("admin/authentication/login"); ?>' class='ym-form'>
						    <!-- 
						    <p><strong><?php echo $summary; ?></strong><br /><br /></p>
						     -->
						    <!-- username input part -->
						    <div class="ym-fbox-text">
						        <label for='user'><?php $clang->eT("Username"); ?></label>
						            <input name='user' id='user' type='text' size='40' maxlength='40' value='' tabindex="1" required="required" />
						    </div>
						    
						    <!-- password input part -->
						    <div class="ym-fbox-text">
						        <label for='password'>
						        <?php $clang->eT("Password"); ?>
						        <?php
						        if (Yii::app()->getConfig("display_user_password_in_email") === true)
						        {
						            ?>
						            <a tabindex='4' href='<?php echo $this->createUrl("admin/authentication/forgotpassword"); ?>'><?php $clang->eT("Forgot your password?"); ?></a>
						            <?php
						        }
						        ?></label>
						        <input name='password' id='password' type='password' size='40' maxlength='40' tabindex='2' required='required' />
						            
							</div>
							<!-- language setting selected part -->
							<div class="ym-fbox-select">
						        <label for='loginlang'><?php $clang->eT("Language"); ?></label>
						        <select id='loginlang' name='loginlang'>
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
						    </div>
						    
						   	<input type='hidden' name='action' value='login' />
						   	<div class='ym-fbox-button'>
						       	<input type='submit' value='<?php $clang->eT("Login"); ?>' class='ym-button' tabindex='3'/>
						    </div>
						
						</form>
					</aside>
				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript'>
	    document.getElementById('user').focus();
	</script>