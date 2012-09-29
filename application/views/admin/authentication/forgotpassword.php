	</div>
</header>
<div id="pagetitle">
</div>
<div id="page">
	<div class="wrapper">
	<section class='full'>
		<h3><?php $clang->eT('Recover your password'); ?></h3>
	    <span class='subtitle'><?php $clang->eT('To receive a new password by email you have to enter your user name and original email address.'); ?></span>
	    <hr/>
		<form class="form44" name="forgotpassword" id="forgotpassword" method="post" action="<?php echo $this->createUrl("admin/authentication/forgotpassword"); ?>" >
	    <p>
	    	<label for="user"><?php $clang->eT('User name'); ?></label><br/>
	    	<input name="user" id="user" type="text" size="60" maxlength="60" value="" />
	    </p>
	    <p>
	    	<label for="email"><?php $clang->eT('Email'); ?></label><br/>
	    	<input name="email" id="email" type="email" size="60" maxlength="60" value="" />
	    </p>
	    <p class='box'>
	        <input type="hidden" name="action" value="forgotpass" />
	        <input class="btn btn-green" type="submit" value="<?php $clang->eT('Check data'); ?>" />
	    </p>
		<p>
			<a href="<?php echo $this->createUrl("/admin"); ?>"><?php $clang->eT('Main Admin Screen'); ?></a>
		</p>
		</form>
		<div class='clear'>&nbsp;</div>
	</section>