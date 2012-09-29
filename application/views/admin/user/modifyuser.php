<section class="width8">
	<h3 id="survey user management"><?php $clang->eT("Editing user");?></h3>
	<hr />
	<form action='<?php echo $this->createUrl("admin/user/moduser");?>'	method='post'>

<?php
function rsdsl($mur) {
	foreach ( $mur as $mds ) {
		if (is_array ( $mds )) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
if (rsdsl ( $mur )) {
	foreach ( $mur as $mrw ) {
?>
    <td align='center'><strong><?php echo $mrw['users_name'];?></strong></td>
				<td align='center'><input type='email' size='30' name='email'
					value="<?php echo $mrw['email'];?>" /></td>
				<td align='center'><input type='text' size='30' name='full_name'
					value="<?php echo $mrw['full_name'];?>" /> <input type='hidden'
					name='user' value="<?php echo $mrw['users_name'];?>" /> <input
					type='hidden' name='uid' value="<?php echo $mrw['uid'];?>" /></td>
				<td align='center'><input type='password' name='pass'
					value="%%unchanged%%" /></td>
<?php
	
}
} else {
	$mur = array_map ( 'htmlspecialchars', $mur );
	?>
			<p>
				<label class="required" for="username"><?php $clang->eT("Username");?></label><br/>
				<strong><?php echo $mur['users_name'];?></strong>
			</p>
			<p>
				<label class="required" for="email"><?php $clang->eT("Email");?></label><br/>
				<input type='email' class="half" name='email' value="<?php echo $mur['email'];?>" />
			</p>
			<p>
				<label class="required" for="fullname"><?php $clang->eT("Full name");?></label><br/>
				<input type='text' class="half" name='full_name' value="<?php echo $mur['full_name'];?>" />
				<input type='hidden' name='user' value="<?php echo $mur['users_name'];?>" />
				<input type='hidden' name='uid' value="<?php echo $mur['uid'];?>" />
			</p>
			<p>
				<label class="required" for="password"><?php $clang->eT("Password");?></label><br/>
				<input type='password' class="half" name='pass' value="%%unchanged%%" />
			</p>

<?php } ?>
			<p class="box">
				<input class='btn btn-green' type='submit' value='<?php $clang->eT("Save");?>' /><input type='hidden' name='action' value='moduser' />
			</p>

	</form>
</section>