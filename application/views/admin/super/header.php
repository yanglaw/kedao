<!DOCTYPE html>
<html lang="<?php echo $adminlang; ?>"<?php echo $languageRTL;?>>
<head>
    <?php echo $meta;?>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.qtip.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.notify.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.tabs.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.syncheight.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('adminscripts');?>admin_core.js"></script>
    <?php echo $datepickerlang;?>
    <title><?php echo $sitename;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>printablestyle.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>adminstyle.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('styleurl');?>adminstyle.css" />

    <?php
    if(!empty($css_admin_includes)) {
        foreach ($css_admin_includes as $cssinclude)
        {
            ?>
            <link rel="stylesheet" type="text/css" media="all" href="<?php echo $cssinclude; ?>" />
            <?php
        }
    }
    ?>
    <?php

        if ($bIsRTL){?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>adminstyle-rtl.css" /><?php
        }

            ?>
    <link rel="shortcut icon" href="<?php echo $baseurl;?>styles/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="<?php echo $baseurl;?>styles/favicon.ico" type="image/x-icon" />
    <?php echo $firebug ?>
</head>
<body>
<?php if(isset($formatdata)) { ?>
    <script type='text/javascript'>
        var userdateformat='<?php echo $formatdata['jsdate']; ?>';
        var userlanguage='<?php echo $adminlang; ?>';
    </script>
    <?php } ?>
    <?php if(isset($flashmessage)) { ?>
        <div id="flashmessage" style="display:none;">

            <div id="themeroller" class="ui-state-highlight ui-corner-all">
                <!-- close link -->
                <a class="ui-notify-close" href="#">
                    <span class="ui-icon ui-icon-close" style="float:right">&nbsp;</span>
                </a>

                <!-- alert icon -->
                <span style="float:left; margin:2px 5px 0 0;" class="ui-icon ui-icon-info">&nbsp;</span>
                <p><?php echo $flashmessage; ?></p><br>
            </div>

            <!-- other templates here, maybe.. -->
        </div>
    <?php } ?>
    <header>
		<div class="ym-wrapper">
			<div class="ym-wbox">
				<div class="float-right">
				<?php
				if(Yii::app()->session['loginID'])
		    	{ ?>
		 			<?php $clang->eT("Logged in as:");?>
			        <a href='<?php echo $this->createUrl("/admin/user/personalsettings"); ?>' title='<?php $clang->eT("Edit your personal preferences");?>'><strong><?php echo Yii::app()->session['user'];?></strong></a>
		 		| <a href="<?php echo $this->createUrl("admin/authentication/logout"); ?>" title="<?php $clang->eT("Logout");?>" ><?php $clang->eT("Logout");?></a> | 
		 		<?php } ?>
		 		<a href="#" title='Help Online'>Help Online</a>
        		</div>
	        	<h1><?php echo $sitename; ?></h1>