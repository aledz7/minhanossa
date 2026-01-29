<?php
if($FiltrosInstanciada == '') {
	if(file_exists('Connections/con-pdo.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
		include('class/conteudos.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
		include('../class/conteudos.php');
	}
	
	class Filtros {
		
		function selectFiltros($idMenu, $nomeCampo, $orderBy="", $porTipo="", $onChange="", $selecionado='', $id="", $campoLabel='titulo', $class="txtboxLivre", $style="") {
			$dados = Conteudos::getInstance(Conexao::getInstance())->rsDados($idMenu, $id, $orderBy, $porTipo);
			//print_r($dados); exit;
			
			if($onChange <> '') {
				$htmlOnChange = "onChange=\"{$onChange}\"";
			}
			?>
			<select name="<?=$nomeCampo;?>" <?=$htmlOnChange;?> id="<?=$nomeCampo;?>" class=" <?=$class;?>" style=" <?=$style;?>">
				<option value=""></option>
					<?php 
					foreach($dados as $dado) {
					?>
						<option value="<?php echo $dado->id?>" <?php if($dado->id == $selecionado) { echo 'selected="selected"'; } ?>><?php echo $dado->$campoLabel;?></option>
					<?php 
					}
					?>
			</select>
        <?php
		}
	}
	
	$FiltrosInstanciada = 'S';
}