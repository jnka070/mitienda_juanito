<div class="instaweb-form--container">
	<div id="div_cliente">
		<input type="text" id="instaweb_cchname" class="instaweb-form--input instaweb-form--name" name="card_holder_name" tabindex="1" title="<?php _e(__('Nombre y Apellido', 'instaweb')); ?>" placeholder="<?php _e(__('Nombre y Apellido', 'instaweb')); ?>" autocomplete="off" maxlength="25" pattern="[A-Za-zñ ]*" oninput="this.value = this.value.replace(/[^A-Za-zñ ]/g, '');">
		<select id="instaweb_chid" class="instaweb-form--select instaweb-form--tipe" name="instaweb_chid" tabindex="2" title="<?php _e(__('Tipo de Identificación', 'instaweb')); ?>">
			<option value="V" selected>V</option>
			<option value="E">E</option>
			<option value="J">J</option>
			<option value="G">G</option>
		</select>
		<input type="text" id="instaweb_cchnameid" class="instaweb-form--input instaweb-form--cchnameid" name="user_dni" tabindex="3" placeholder="<?php _e(__('Número de Identificación', 'instaweb')); ?>" autocomplete="off" minlength="6" maxlength="8" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
	</div>
	<div id="div_tarjetas">
		<input type="text" id="instaweb_ccnum" class="instaweb-form--input instaweb-form--tdc-number" name="valid_card_number" tabindex="4" placeholder="<?php _e(__('Número de tarjeta', 'instaweb')); ?>" autocomplete="off" maxlength="16" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="<?php _e(__('Número de tarjeta', 'instaweb')); ?>">
		<input type="password" id="instaweb_cvv" class="instaweb-form--input instaweb-form--ccv" name="cvc_code" tabindex="5" placeholder="<?php _e(__('Cód de seguridad', 'instaweb')); ?>" autocomplete="off" maxlength="3" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="<?php _e(__('Cód de seguridad', 'instaweb')); ?>">
	</div>
	<p class="instaweb-form--txt-help"><?php _e(__('Fecha de vencimiento', 'instaweb')); ?></p>
	<div id="div_venc">
		<select id="exp_month" class="instaweb-form--select instaweb-form--exp-month" name="exp_month" tabindex="6">
			<option value="-1"><?php _e(__('Mes', 'instaweb')); ?></option>
			<?php
			$months = [
				'01',
				'02',
				'03',
				'04',
				'05',
				'06',
				'07',
				'08',
				'09',
				'10',
				'11',
				'12',
			];
			$mesActual = date('m');
			foreach ($months as $mes) {
				$selected = ($mes == $mesActual) ? 'selected' : '';
				echo '<option value="' . $mes . '" ' . $selected . '>' . $mes . '</option>';
			}
			?>
		</select>
		<select id="exp_year" class="instaweb-form--select instaweb-form--exp-year" name="exp_year" tabindex="7">
			<option value="-1" selected><?php _e(__('AÑO', 'instaweb')); ?></option>
			<?php
			/**
			 * for ($y = date('Y'); $y <= date('Y') + 10; $y++)
			 * Utilizar la funcion date limita el uso de tarjetas
			 * emitidas en el año en curso del sistema operativo,
			 * con un rango de 10 años se asegura el uso de tarjetas vijentes.
			 */
			$x = date('Y');
			for ($y = 2022; $y <= 2022 + 10; $y++) {
				$selected = ($y == $x) ? 'selected' : '';
				echo '<option value="' . $y . '" ' . $selected . '>' . $y . '</option>';
			}
			?>
		</select>
	</div>
	<div class="instaweb-visa-mastercard">
		<img src="<?php echo plugins_url('instaweb/public/img/instaweb-visa-mastercard.png'); ?>" class="iq-visa-mastercard" alt="Número de Tarjeta">
	</div>
	<!-- <div class="tdc-logos">
	</div> -->
	<div class="instaweb-copy instaweb-text-center">
		<div class="instaweb-text-img">
			<div class="instaweb-text">
				<p class="instaweb-form--txt-help">
					<?php _e(__('Esta transacción será procesada por Insta Web de Instapago', 'instaweb')); ?>
				</p>
			</div>
			<div class="instaweb-img-container">
				<img src="<?php echo plugins_url('instaweb/public/img/instapagoisotipodegrade-01.png'); ?>" class="instaweb-img" alt="Instapago">
			</div>
		</div>
		<p><?php _e(__('Powered By')); ?>
			<a href="https://iqtsystems.com/" target="_blank"><?php _e(__('IQ Technology Systems')) ?></a>
		</p>
	</div>
</div>