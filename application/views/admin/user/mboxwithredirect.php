<section class="width8">
	<h3><?php echo $title; ?></h3>
	<hr />
	<div class="box box-warning">
	    <?php echo $message; ?>&nbsp;<?php echo $extra; ?>
	</div>
	    <p />
	<p>
	    <form method="post" action="<?php echo $url; ?>">
	        <input type="submit" class="btn btn-green" value="<?php echo $urlText; ?>" />
	        <?php
	        if (!empty($hiddenVars))
	        {
	            foreach ($hiddenVars as $key => $value)
	            {
	?>
	                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
	<?php
	            }
	        }
	        ?>
	    </form>
	</p>
</section>