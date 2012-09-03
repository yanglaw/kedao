<form id='exportstructureGroup' name='exportstructureGroup' action='<?php echo $this->createUrl("admin/export/group/surveyid/$surveyid/gid/$gid");?>' method='post'>
<div class='header ui-widget-header'><?php $clang->eT("Export group structure");?></div>
<ul>
<li>
<input type='radio' class='radiobtn' name='type' value='structurecsvGroup' checked='checked' id='surveycsv'
onclick="this.form.action.value='exportstructurecsvGroup'"/>
<label for='surveycsv'><?php $clang->eT("LimeSurvey group file (*.csv)");?></label></li>
<?php if(Yii::app()->getConfig('export4lsrc')) { ?>
    <li><input type='radio' class='radiobtn' name='type' value='structureLsrcCsvGroup'  id='LsrcCsv' onclick="this.form.action.value='exportstructureLsrcCsvGroup'" />
    <label for='LsrcCsv'><?php $clang->eT("Save for Lsrc (*.csv)");?></label></li>
<?php } ?>
</ul>
<p>
<input type='submit' value='<?php $clang->eT("Export to file");?>' />
<input type='hidden' name='sid' value='$surveyid' />
<input type='hidden' name='gid' value='$gid' />
<input type='hidden' name='action' value='exportstructurecsvGroup' />
</form>