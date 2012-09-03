<table <?php echo $showstyle; ?> id='surveydetails'>
	<tr>
		<td>
			<strong><?php $clang->eT("Title");?>:</strong>
		</td>
		<td class='settingentryhighlight'>
			<?php echo $surveyinfo['surveyls_title']." (".$clang->gT("ID")." ".$surveyinfo['sid'].")";?>
		</td>
	</tr>
	<tr>
		<td>
			<strong><?php echo $clang->gT("Survey URL") ." (".getLanguageNameFromCode($surveyinfo['language'],false)."):";?></strong>
		</td>
		<td>
		<?php $tmp_url = $this->createAbsoluteUrl("/survey/index/sid/{$surveyinfo['sid']}");
        echo "<a href='{$tmp_url}/lang/{$surveyinfo['language']}' target='_blank'>{$tmp_url}/lang/{$surveyinfo['language']}</a>";
        foreach ($aAdditionalLanguages as $langname)
        {
            echo "&nbsp;<a href='{$tmp_url}/lang/$langname' target='_blank'><img title='".$clang->gT("Survey URL for language:")." ".getLanguageNameFromCode($langname,false)
            ."' alt='".getLanguageNameFromCode($langname,false)." ".$clang->gT("Flag")."' src='".Yii::app()->getConfig("imageurl")."/flags/{$langname}.png' /></a>";
        } ?>
		</td>
	</tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Description:");?></strong>
    	</td>
    	<td>
        	<?php
                if (trim($surveyinfo['surveyls_description']) != '')
                {
                    templatereplace($surveyinfo['surveyls_description']);
                    echo LimeExpressionManager::GetLastPrettyPrintExpression();
                }
            ?>
        </td>
	</tr>
	<tr>
		<td>
			<strong><?php $clang->eT("Welcome:");?></strong>
		</td>
        <td>
        	<?php
                templatereplace($surveyinfo['surveyls_welcometext']);
                echo LimeExpressionManager::GetLastPrettyPrintExpression();
            ?>
        </td>
	</tr>
	<tr>
		<td>
			<strong><?php $clang->eT("End message:");?></strong>
		</td>
        <td>
        	<?php
                templatereplace($surveyinfo['surveyls_endtext']);
                echo LimeExpressionManager::GetLastPrettyPrintExpression();
            ?>
        </td>
	</tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Administrator:");?></strong>
    	</td>
        <td>
        	<?php echo "{$surveyinfo['admin']} ({$surveyinfo['adminemail']})";?>
        </td>
	</tr>
	<?php if (trim($surveyinfo['faxto'])!='') { ?>
	    <tr>
	    	<td>
	    		<strong><?php $clang->eT("Fax to:");?></strong>
	    	</td>
	    	<td>
	    		<?php echo$surveyinfo['faxto'];?>
	    	</td>
	    </tr>
    <?php } ?>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Start date/time:");?></strong>
    	</td>
        <td>
        	<?php echo $startdate;?>
        </td>
    </tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Expiry date/time:");?></strong>
    	</td>
    	<td>
    		<?php echo $expdate;?>
    	</td>
    </tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Template:");?></strong>
    	</td>
    	<td>
    		<?php echo $surveyinfo['template'];?>
    	</td>
    </tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Base language:");?></strong>
    	</td>
    	<td>
    		<?php echo $language;?>
    	</td>
    </tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Additional languages:");?></strong>
    	</td>
    		<?php echo $additionnalLanguages;?>
    <tr>
    	<td>
    		<strong><?php $clang->eT("End URL");?>:</strong>
    	</td>
    	<td>
    		<?php echo $endurl;?>
    	</td>
    </tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Number of questions/groups");?>:</strong>
    	</td>
    	<td>
    		<?php echo $sumcount3."/".$sumcount2;?>
    	</td>
    </tr>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Survey currently active");?>:</strong>
    	</td>
    	<td>
    		<?php echo $activatedlang;?>
    	</td>
    </tr>
    <?php if($activated=="Y") { ?>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Survey table name");?>:</strong>
    	</td>
    	<td>
    		<?php echo $surveydb;?>
    	</td>
    </tr>
    <?php } ?>
    <tr>
    	<td>
    		<strong><?php $clang->eT("Hints");?>:</strong>
    	</td>
    	<td>
    		<?php echo $warnings.$hints;?>
    	</td>
    </tr>
    <?php if ($tableusage != false){
            if ($tableusage['dbtype']=='mysql' || $tableusage['dbtype']=='mysqli'){
                $column_usage = round($tableusage['column'][0]/$tableusage['column'][1] * 100,2);
                $size_usage =  round($tableusage['size'][0]/$tableusage['size'][1] * 100,2); ?>
                <tr><td><strong><?php $clang->eT("Table column usage");?>: </strong></td><td><div class='progressbar' style='width:20%; height:15px;' name='<?php echo $column_usage;?>'></div> </td></tr>
                <tr><td><strong><?php $clang->eT("Table size usage");?>: </strong></td><td><div class='progressbar' style='width:20%; height:15px;' name='<?php echo $size_usage;?>'></div></td></tr>
            <?php }
            elseif (($arrCols['dbtype'] == 'mssql')||($arrCols['dbtype'] == 'postgre')){
                $column_usage = round($tableusage['column'][0]/$tableusage['column'][1] * 100,2); ?>
                <tr><td><strong><?php $clang->eT("Table column usage");?>: </strong></td><td><strong><?php echo $column_usage;?>%</strong><div class='progressbar' style='width:20%; height:15px;' name='<?php echo $column_usage;?>'></div> </td></tr>
            <?php }
        } ?>
</table>