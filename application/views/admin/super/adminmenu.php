	<nav id="menu">
		<ul class="sf-menu">
			<li><a href="<?php echo $this->createUrl("/admin"); ?>" title="<?php $clang->eT("Default Administration Page");?>"><strong><?php $clang->eT("Default Page");?></strong></a></li>
			<li><a href="<?php echo $this->createUrl("admin/user/index"); ?>" title="<?php $clang->eT("Create/Edit Users");?>" ><?php $clang->eT("Users Management");?></a>
				<ul>
					<li><a href="<?php echo $this->createUrl("admin/usergroups/index"); ?>" title="<?php $clang->eT("Create/Edit Groups");?>" ><?php $clang->eT("User Groups Management");?></a></li>
				</ul>
			</li>
			<?php
				if(Yii::app()->session['USER_RIGHT_SUPERADMIN'] == 1)
				{ ?>
            <li><a href="<?php echo $this->createUrl("admin/globalsettings"); ?>" title="<?php $clang->eT("Global settings");?>" ><?php $clang->eT("Global settings");?></a>
            	<ul>
			    <li><a href="<?php echo $this->createUrl("admin/checkintegrity"); ?>" title="<?php $clang->eT("Check Data Integrity");?>">
			    <?php $clang->eT("Check Data Integrity");?></a></li>
				<?php
			        if (in_array(Yii::app()->db->getDriverName(), array('mysql', 'mysqli')) || Yii::app()->getConfig('demoMode') == true)
			        {
						?>
						<li><a href="<?php echo $this->createUrl("admin/dumpdb"); ?>" title="<?php $clang->eT("Backup Entire Database");?>" >
						<?php $clang->eT("Backup Entire Database");?></a></li>
		        <?php }  ?>
		        </ul>
		    </li>
		     <?php }  ?>
			<?php
			    if(Yii::app()->session['USER_RIGHT_MANAGE_LABEL'] == 1)
				{ ?>
			<li><a href="<?php echo $this->createUrl("admin/labels/view"); ?>" title="<?php $clang->eT("Edit label sets");?>" >
			    <?php $clang->eT("Edit label sets");?></a></li>
			<?php } ?>
			<?php 
			    if(Yii::app()->session['USER_RIGHT_MANAGE_TEMPLATE'] == 1)
				{ ?>
			<li><a href="<?php echo $this->createUrl("admin/templates/view"); ?>" title="<?php $clang->eT("Template Editor");?>" >
			    <?php $clang->eT("Template Editor");?></a></li>
			<?php } ?>
			<?php
		        if(Yii::app()->session['USER_RIGHT_PARTICIPANT_PANEL'] == 1)
				{ 	 ?>
            <li><a href="<?php echo $this->createUrl("admin/participants/index"); ?>" title="<?php $clang->eT("Participant panel");?>" >
	        	<?php $clang->eT("Participant panel");?></a></li>
	        <?php } ?>
			
			<li><label for='surveylist'><?php $clang->eT("Surveys:");?></label>
		    <select id='surveylist' name='surveylist' onchange="window.open(this.options[this.selectedIndex].value,'_top')">
		    <?php echo getSurveyList(false, false, $surveyid); ?>
		    </select></li>
	        <li><a href="<?php echo $this->createUrl("admin/survey/index"); ?>" title="<?php $clang->eT("Detailed list of surveys");?>" >
	        <?php $clang->eT("Detailed list of surveys");?></a></li>
			<?php
			    if(Yii::app()->session['USER_RIGHT_CREATE_SURVEY'] == 1)
				{ ?>
		
			    <li><a href="<?php echo $this->createUrl("admin/survey/newsurvey"); ?>" title="<?php $clang->eT("Create, import, or copy a survey");?>" >
			    <?php $clang->eT("Create survey");?></a></li>
		    <?php } ?>
		</ul>
	</nav>
	</div>
</header>
	<div id="pagetitle">
	</div>
	<div id="page">
		<div class="wrapper">