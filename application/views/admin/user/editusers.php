<section class="width8">
	<h3 id="survey user management"><?php $clang->eT("Users Management");?></h3>
<hr />
<table id='users' class='display stylized'>
    <thead>
        <tr>
            <th><?php $clang->eT("Action");?></th>
            <th><?php $clang->eT("Username");?></th>
            <th><?php $clang->eT("Email");?></th>
            <th><?php $clang->eT("Full name");?></th>
            <?php if(Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1) { ?>
                <th><?php $clang->eT("No of surveys");?></th>
                <?php } ?>
            <th><?php $clang->eT("Created by");?></th>
        </tr></thead>
	<tbody>
        <tr >
            <td align='center' style='padding:3px;'>
                <form method='post' action='<?php echo $this->createUrl("admin/user/modifyuser");?>'>
                    <input type='image' src='<?php echo $imageurl;?>operate/edit_16.png' value='<?php $clang->eT("Edit user");?>' />
                    <input type='hidden' name='action' value='modifyuser' />
                    <input type='hidden' name='uid' value='<?php echo htmlspecialchars($usrhimself['uid']);?>' />
                </form>

                <?php if ($usrhimself['parent_id'] != 0 && Yii::app()->session['USER_RIGHT_DELETE_USER'] == 1 ) { ?>
                    <form method='post' action='$scriptname?action=deluser' onsubmit='return confirm("<?php $clang->eT("Are you sure you want to delete this entry?","js");?>")' >
                        <input type='submit' value='<?php $clang->eT("Delete");?>' />
                        <input type='hidden' name='action' value='deluser' />
                        <input type='hidden' name='user' value='<?php echo htmlspecialchars($usrhimself['user']);?>' />
                        <input type='hidden' name='uid' value='<?php echo $usrhimself['uid'];?>' />
                    </form>
                    <?php } ?>

            </td>

            <td align='center'><strong><?php echo htmlspecialchars($usrhimself['user']);?></strong></td>
            <td align='center'><strong><?php echo htmlspecialchars($usrhimself['email']);?></strong></td>
            <td align='center'><strong><?php echo htmlspecialchars($usrhimself['full_name']);?></strong></td>

            <?php if(Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1) { ?>
                <td align='center'><strong><?php echo $noofsurveys;?></strong></td>
                <?php } ?>

            <?php if(isset($usrhimself['parent_id']) && $usrhimself['parent_id']!=0) { ?>
                <td align='center'><strong><?php echo $row;?></strong></td>
                <?php } else { ?>
                <td align='center'><strong>---</strong></td>
                <?php } ?>
        </tr>

        <?php for($i=1; $i<=count($usr_arr); $i++) {
                $usr = $usr_arr[$i];
                $usr=array_map('htmlspecialchars', $usr);
            ?>
            <tr>

                <td align='center' style='padding:3px;'>
                    <?php if (Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1 || $usr['uid'] == Yii::app()->session['loginID'] || (Yii::app()->session['USER_RIGHT_CREATE_USER'] == 1 && $usr['parent_id'] == Yii::app()->session['loginID'])) { ?>
                        <form method='post' action='<?php echo $this->createUrl("admin/user/modifyuser");?>'>
                            <input type='image' src='<?php echo $imageurl;?>operate/edit_16.png' alt='<?php $clang->eT("Edit this user");?>' />
                            <input type='hidden' name='action' value='modifyuser' />
                            <input type='hidden' name='uid' value='<?php echo $usr['uid'];?>' />
                        </form>
                        <?php } ?>

                    <?php if ( ((Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1 &&
                        $usr['uid'] != Yii::app()->session['loginID'] ) ||
                        (Yii::app()->session['USER_RIGHT_CREATE_USER'] == 1 &&
                        $usr['parent_id'] == Yii::app()->session['loginID'])) && $usr['uid']!=1) { ?>
                        <form method='post' action='<?php echo $this->createUrl("admin/user/setUserRights/");?>'>
                            <input type='image' src='<?php echo $imageurl;?>operate/security_16.png' alt='<?php $clang->eT("Set global permissions for this user");?>' />
                            <input type='hidden' name='action' value='setUserRights' />
                            <input type='hidden' name='user' value='<?php echo $usr['user'];?>' />
                            <input type='hidden' name='uid' value='<?php echo $usr['uid'];?>' />
                        </form>
                        <?php }
                        if (Yii::app()->session['loginID'] == "1" && $usr['parent_id'] !=1 ) { ?>

                        <form method='post' action='<?php echo $this->createUrl("admin/user/setasadminchild/");?>'>
                            <input type='image' src='<?php echo $imageurl;?>/takeownership.png' alt='<?php $clang->eT("Take ownership");?>' />
                            <input type='hidden' name='action' value='setasadminchild' />
                            <input type='hidden' name='user' value='<?php echo $usr['user'];?>' />
                            <input type='hidden' name='uid' value='<?php echo $usr['uid'];?>' />
                        </form>
                        <?php }
                        if ((Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1 || Yii::app()->session['USER_RIGHT_MANAGE_TEMPLATE'] == 1)  && $usr['uid']!=1) { ?>
                        <form method='post' action='<?php echo $this->createUrl("admin/user/setusertemplates/");?>'>
                            <input type='image' src='<?php echo $imageurl;?>operate/templatepermissions_small.png' alt='<?php $clang->eT("Set template permissions for this user");?>' />
                            <input type='hidden' name='action' value='setusertemplates' />
                            <input type='hidden' name='user' value='<?php echo $usr['user'];?>' />
                            <input type='hidden' name='uid' value='<?php echo $usr['uid'];?>' />
                        </form>
                        <?php }
                        if ((Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1 || (Yii::app()->session['USER_RIGHT_DELETE_USER'] == 1  && $usr['parent_id'] == Yii::app()->session['loginID']))&& $usr['uid']!=1) { ?>
                        <form method='post' action='<?php echo $this->createUrl("admin/user/deluser");?>'>
                            <input type='image' src='<?php echo $imageurl;?>operate/token_delete.png' alt='<?php $clang->eT("Delete this user");?>' onclick='return confirm("<?php $clang->eT("Are you sure you want to delete this entry?","js");?>")' />
                            <input type='hidden' name='action' value='deluser' />
                            <input type='hidden' name='user' value='<?php echo $usr['user'];?>' />
                            <input type='hidden' name='uid' value='<?php echo $usr['uid'];?>' />
                        </form>
                        <?php } ?>

                </td>
                <td align='center'><?php echo $usr['user'];?></td>
                <td align='center'><a href='mailto:<?php echo $usr['email'];?>'><?php echo $usr['email'];?></a></td>
                <td align='center'><?php echo $usr['full_name'];?></td>

                <td align='center'><?php echo $noofsurveyslist[$i];?></td>

                <?php $uquery = "SELECT users_name FROM {{users}} WHERE uid=".$usr['parent_id'];
                    $uresult = dbExecuteAssoc($uquery); //Checked
                    $userlist = array();
                    $srow = $uresult->read();

                    $usr['parent'] = $srow['users_name']; ?>

                <?php if (isset($usr['parent_id'])) { ?>
                    <td align='center'><?php echo $usr['parent'];?></td>
                    <?php } else { ?>
                    <td align='center'>-----</td>
                    <?php } ?>

            </tr>
            <?php $row++;
        } ?>
    </tbody>
</table>
<div class="clear">&nbsp;</div>
<?php if(Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1 || Yii::app()->session['USER_RIGHT_CREATE_USER']) { ?>
	<h4><?php $clang->eT("Add user:");?></h4>
    <form action='<?php echo $this->createUrl("admin/user/adduser");?>' method='post'>
        <fieldset>
        	<legend>Product info</legend>
        	<p>
        		<label class="required" for="new_user"><?php $clang->eT("Username");?></label><br/>
        		<input type='text' id="new_user" name='new_user' required="required" class="half title" />
        	</p>
        	<p>
        		<label class="required" for="new_email"><?php $clang->eT("Email");?></label><br/>
        		<input type='text' id="new_email" name='new_email' required="required" class="half title" />
        	</p>
        	<p>
        		<label class="required" for="new_full_name"><?php $clang->eT("Full name");?></label><br/>
        		<input type='text' id="new_full_name" name='new_full_name' required="required" class="half title" />
        	</p>
            <p class="box"><input type='submit' class="btn btn-green" value='<?php $clang->eT("Add User");?>' /></p>
            <input type='hidden' name='action' value='adduser' /></td>
		</fieldset>
	</form><br />
    <?php } ?>
</section>