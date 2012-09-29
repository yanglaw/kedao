<section class="column width6 first">
    <h3><?php echo sprintf($clang->gT("Welcome to %s!"), 'LimeSurvey'); ?></h3>
    <hr />
    <div class="width8"><?php $clang->eT("Some piece-of-cake steps to create your very own first survey:"); ?></div><br />
    <ol>
        <li><?php echo sprintf($clang->gT('Create a new survey clicking on the %s icon in the upper right.'), "<img src='" . Yii::app()->getConfig('adminimageurl') . "add_20.png' name='ShowHelp' title='' alt='" . $clang->gT("Add survey") . "'/>"); ?></li>
        <li><?php $clang->eT('Create a new question group inside your survey.'); ?></li>
        <li><?php $clang->eT('Create one or more questions inside the new question group.'); ?></li>
        <li><?php echo sprintf($clang->gT('Done. Test your survey using the %s icon.'), "<img src='" . Yii::app()->getConfig('adminimageurl') . "do_20.png' name='ShowHelp' title='' alt='" . $clang->gT("Test survey") . "'/>"); ?></li>
    </ol>
    <br />
    <div class="clear">&nbsp;</div>
</section>
<aside class="column width2">
	<div id="rightmenu">
		<header>
			<h3>Create Survey</h3>
		</header>
		<dl class="first">
			<dt><img width="16" height="16" alt="" src="img/key.png"></dt>
			<dd><a href="#">Create Blank Survey</a></dd>
			<dd class="last">Create a blank survey with nothing data in it.</dd>
			
			<dt><img width="16" height="16" alt="" src="img/help.png"></dt>
			<dd><a href="#">Create Survey From Template</a></dd>
			<dd class="last">Create a survey from template.</dd>
			
			<dt><img width="16" height="16" alt="" src="img/help.png"></dt>
			<dd><a href="#">Import Survey from a file</a></dd>
			<dd class="last">Create a survey from template.</dd>
		</dl>
	</div>
	<div class="clear">&nbsp;</div>
</aside>
