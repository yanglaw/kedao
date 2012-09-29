<section class="width8">
    <h3><?php $clang->eT("Your personal settings"); ?></h3>
	<hr />
	<div class="width8">
    <?php echo CHtml::form($this->createUrl("/admin/user/personalsettings"), 'post', array('class' => 'form44')); ?>
    <p>
    	<label><?php echo CHtml::label($clang->gT("Interface language"), 'lang'); ?></label><br />
    	<select id='lang' name='lang' class="half">
        	<option value='auto'<?php if ($sSavedLanguage == 'auto') { echo " selected='selected'"; } ?>>
			<?php $clang->eT("(Autodetect)"); ?>
			</option>
			<?php foreach (getLanguageData(true, Yii::app()->session['adminlang']) as $langkey => $languagekind)
				{ ?>
					<option value='<?php echo $langkey; ?>'<?php if ($langkey == $sSavedLanguage) {
					echo " selected='selected'";
				} ?>>
			<?php echo $languagekind['nativedescription']; ?> - <?php echo $languagekind['description']; ?>
			</option>
			<?php } ?>
		</select>
	</p>
    <p>
    	<label><?php echo CHtml::label($clang->gT("HTML editor mode"), 'htmleditormode'); ?></label><br />    	
		<?php
			echo CHtml::dropDownList('htmleditormode', Yii::app()->session['htmleditormode'], array(
				'default' => $clang->gT("Default"),
				'inline' => $clang->gT("Inline HTML editor"),
				'popup' => $clang->gT("Popup HTML editor"),
				'none' => $clang->gT("No HTML editor")
			));
		?>
	</p>
    <p>
    	<label><?php echo CHtml::label($clang->gT("Question type selector"), 'questionselectormode'); ?></label><br />  	
        <?php
			echo CHtml::dropDownList('questionselectormode', Yii::app()->session['questionselectormode'], array(
				'default' => $clang->gT("Default"),
				'full' => $clang->gT("Full selector"),
				'none' => $clang->gT("Simple selector")
			));
		?>
	</p>
    <p>
    	<label><?php echo CHtml::label($clang->gT("Template editor mode"), 'templateeditormode'); ?></label><br />
		<?php
			echo CHtml::dropDownList('templateeditormode', Yii::app()->session['templateeditormode'], array(
				'default' => $clang->gT("Default"),
                'full' => $clang->gT("Full template editor"),
                'none' => $clang->gT("Simple template editor")
			));
		?>
	</p>
    <p>
    	<label><?php echo CHtml::label($clang->gT("Date format"), 'dateformat'); ?></label><br />
		<select name='dateformat' id='dateformat' class='half'>
		<?php
			foreach (getDateFormatData() as $index => $dateformatdata)
			{
				echo "<option value='{$index}'";
				if ($index == Yii::app()->session['dateformat'])
				{
					echo " selected='selected'";
				}
				echo ">" . $dateformatdata['dateformat'] . '</option>';
			}
		?>
		</select>
	</p>
	<p class="box">
		<?php echo CHtml::hiddenField('action', 'savepersonalsettings'); ?>
		<?php echo CHtml::submitButton($clang->gT("Save settings"), array('class' => 'btn btn-green')); ?>
	</p>
    <?php echo CHtml::endForm(); ?>
	</div>
</section>