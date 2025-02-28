<div style="display: flex; flex-wrap: wrap; gap: 5px; align-items: center;">
	<h3 style="font-size: 25px;">
		<?php _e($this->medthod_title); ?>
	</h3>
	<div class="">
		<img src="<?php echo plugins_url('instaweb/public/img/instapagoisotipodegrade-01.png',); ?>" alt="Instapago" style="max-width: 150px; display: block; margin-bottom: 0px; padding-bottom: 0;">
	</div>
</div>
<p>
	<?php _e($this->method_description); ?>
</p>
<table class="form-table">
	<?php $this->generate_settings_html(); ?>
</table>