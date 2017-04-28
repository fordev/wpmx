<?php
class DB{

private $con;

//construtor para conectar ao banco de dados
public function __construct(){
$this->con = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if($this->con->connect_errno > 0){
	die('There was a problem [' . $con->connect_error . ']');
	}
}

//criar a função que irá baixar um arquivo CSV de uma consulta mysqli

public function downloadCsv(){

$count = 0;
$header = "";
$data = "";
$colunas = 0;

// -- montar sql
switch ($_POST['atualizados']) {
	case 1:
		$sql = "SELECT d.* FROM
			atualizacao_cadastro_titular t,
			atualizacao_cadastro_titular d
			WHERE
			t.codigo_facplan IN (d.codigo_facplan)
			AND t.promocao != ''
			AND t.promocao IS NOT NULL";
		break;

	default:
		$sql = "SELECT * FROM atualizacao_cadastro_titular
		ORDER BY data_cadastro DESC";
		break;
}

//query
$result = $this->con->query($sql);
//contar campos
$count = $result->field_count;
//nomes das colunas
$names = $result->fetch_fields();
//colocar os nomes das colunas em cabeçalho
foreach($names as $value) {
	$header .= $value->name.";";
	}
// }
//colocar linhas de sua consulta
while($row = $result->fetch_row())  {
	$line = '';
	$colunas = 0;
	foreach($row as $value){
		// --multiplos emails remover ";"
		$value = str_replace(";", ",", $value);

		if(!isset($value) || $value == "")  {
			$value = ";"; //neste caso, ";" separa colunas
	} else {
			$value = str_replace('"', '""', $value);

			// --preservar tipo dos campos
			if ($colunas <= 49) {
			$value = '="' . $value . '"' . ";"; //se você alterar o separador antes, alterar esta ";" também

			} else {
			// -- preservar data formato brasileiro
			$value = '"' . $value . '"' . ";"; //se você alterar o separador antes, alterar esta ";" também
			}

		}
		$line .= $value;
		$colunas++;
	} //end foreach
	$data .= trim($line)."\n";
} //end while
//evitando problemas com dados que inclui "\r"
$data = str_replace("\r", "", $data);
//se consulta vazia
if ($data == "") {
	$data = "\nnão há registros\n";
}
$count = $result->field_count;

	//  -- nome
	$date = new DateTime();
	$ts = $date->format("d-m-Y-G-i-s");
	$filename = "dados-beneficiarios-$ts.csv";

	//Download csv file
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$filename);
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $header."\n".$data."\n";
	}

	public function total_geral()	{
		//query
		$result = $this->con->query("SELECT COUNT(*) FROM atualizacao_cadastro_titular");
		//contar campos
		$count = $result->fetch_row();
		return $count[0];
	}

	public function total_atualizados()	{
		//query
		$result = $this->con->query("SELECT COUNT(*) FROM atualizacao_cadastro_titular
			WHERE promocao != '' AND promocao IS NOT NULL");
		//contar campos
		$count = $result->fetch_row();
		return $count[0];
	}
}
