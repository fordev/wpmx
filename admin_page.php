<?php
//call the "class.php" file
require_once 'class.php';
//instantiate DB class
$stats = new DB();
?>
<link rel="stylesheet" href="<?php echo plugins_url('wpmx/css/style.css'); ?>">
<div class="wrap">
	<h2>Exportar dados dos Beneficiários</h2>
	<form method="post" name="ti_xlsx_exporter_form" action="<?php echo plugin_dir_url( __FILE__ ); ?>export.php">
		<br>
		<div class="form-group">
			<legend>Apenas atualizados:</legend>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="atualizados" value="1">
					Marque se deseja <u>apenas os atualizados</u> com código da promoção.
				</label>
				<p>Se não estiver marcado, por padrão será exportado <u>todos os beneficiários</u>.</p>
			</div>
		</div>

		<p class="submit"><input class="button" type="submit" name="Submit" value="Exportar dados agora" /></p>
	</form>
	<hr>
	<h2>Estatísticas gerais em: <?php
$timezone_format = _x('Y-m-d H:i:s', 'timezone date format');
	 echo date_i18n($timezone_format); ?></h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Total de registros</th>
			<th>Total atualizados</th>
			<th>Total pendentes</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php $g = $stats->total_geral(); echo number_format($g, 0, '', '.'); ?> </td>
			<td><?php $a = $stats->total_atualizados(); echo number_format($a, 0, '', '.'); ?></td>
			<td><?php $t = $g-$a; echo number_format($t, 0, '', '.') ?></td>
		</tr>
	</tbody>
</table>
</div>
