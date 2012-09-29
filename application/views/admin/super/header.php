<!DOCTYPE html>
<html lang="<?php echo $adminlang; ?>"<?php echo $languageRTL;?>>
<head>
    <?php echo $meta;?><meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<!-- Main Stylesheet --> 
    <link rel="stylesheet" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>css/style.css" type="text/css" />
    <!-- Your Custom Stylesheet --> 
    <link rel="stylesheet" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>css/custom.css" type="text/css" />
    <!--
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.qtip.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.notify.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.tabs.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>jquery/jquery.syncheight.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('adminscripts');?>admin_core.js"></script>
	--><!--swfobject - needed only if you require <video> tag support for older browsers -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/swfobject.js"></script>
	<!-- jQuery with plugins -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery-1.4.2.min.js"></script>
	<!-- Could be loaded remotely from Google CDN : <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.ui.core.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.ui.tabs.min.js"></script>
	<!-- jQuery tooltips -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.tipTip.min.js"></script>
	<!-- Superfish navigation -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.superfish.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.supersubs.min.js"></script>
	<!-- jQuery form validation -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.validate_pack.js"></script>
	<!-- jQuery popup box -->
    <script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.nyroModal.pack.js"></script>
    <!-- jQuery data tables -->
	<script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.dataTables.min.js"></script>
    <!-- jQuery sliede -->
	<script type="text/javascript" src="<?php echo Yii::app()->getConfig('generalscripts');?>windblue/jquery.KinSlideshow-1.2.1.min.js"></script>   
    <!--
    	commonts by yanglaw for js conflict with totop
    	<?php echo $datepickerlang;?>
    -->
    <title><?php echo $sitename;?></title>
    <!-- 
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>printablestyle.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('adminstyleurl');?>adminstyle.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getConfig('styleurl');?>adminstyle.css" />
     -->

    
    <script type="text/javascript">
    $(document).ready(function(){
    	/* setup navigation, content boxes, etc... */
    	Administry.setup();
    	/* tabs */
    	$("#tabs, #tabs2").tabs();
    	$('#users').dataTable();
    });	
    </script>
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
    <?php echo $firebug ?></head>
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
    <header id="top">
		<div class="wrapper">
			<div id="title"><span><?php echo $sitename; ?></span>demo</div>
			<div id="topnav">
			<?php
			if(Yii::app()->session['loginID'])
	    	{ ?>
	 			<?php $clang->eT("Logged in as:");?>
		        <a href='<?php echo $this->createUrl("/admin/user/personalsettings"); ?>' title='<?php $clang->eT("Edit your personal preferences");?>'><strong><?php echo Yii::app()->session['user'];?></strong></a>
	 			<span>|</span> <a href="<?php echo $this->createUrl("admin/authentication/logout"); ?>" title="<?php $clang->eT("Logout");?>" ><?php $clang->eT("Logout");?></a> <span>|</span> 
	 		<?php } ?>
		 		<a href="#" title='Help Online'>Help Online</a>
        	</div>