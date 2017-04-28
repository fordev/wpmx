<?php
/*
Plugin Name: MySQL para xlsx
Plugin URI: #
Description: Simples exportador de dados personalizdos
Version: 1.2
Author: Fordev
Author URI: http://www.fordev.com.br
*/

add_action('admin_menu', 'ti_exporter_pages');

function ti_exporter_pages() {
	add_management_page('MySQL para xlsx', 'Exportador de dados',
		1, 'ti_xlsx_exporter', 'ti_xlsx_admin');
}

function ti_xlsx_admin() {
	require( dirname( __FILE__ ) . '/admin_page.php' );
}
