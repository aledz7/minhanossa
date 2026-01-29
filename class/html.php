<?php
if($HTMLInstanciada == '') {
	if(file_exists('Connections/con-pdo.php')) {
		include('funcoes.php');
		if(file_exists('class/info-site.php')) {
			include('class/info-site.php');
		} else {
			include('../class/info-site.php');
		}
	} else {
		include('../funcoes.php');
		include('../class/info-site.php');
	}
	
	class HTML {
		
		function menuAtivo($menuAtual, $valor='active') {
			global $menuAtivo;
			
			if($menuAtivo == $menuAtual) {
				return($valor);
			}
		}
		
		function seo_metas_tag($titulo, $descDescription='') {
			$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();
			$description = ($descDescription <> '') ? $descDescription : $infoSite->nome.', '. $titulo;
			
			if(strlen($descDescription) < 100 and $descDescription <> '') {
				$description = $descDescription.', '.$infoSite->nome.', '.$titulo;
			}
			?>
            <title><?=$infoSite->nome;?> - <?=$titulo;?></title>
            <meta name="description" content="<?=$description;?>">
			<meta name="keywords" content="<?=$description;?>">
            <meta name="author" content="www.dfinformatica.com.br" />
			<meta property="og:locale" content="pt_BR" />
            <meta property="og:type" content="website" />
            <meta property="og:title" content="<?=$infoSite->nome;?> - <?=$titulo;?>"/>
            <meta property="og:description" content="<?=$description;?>"/>
            <meta property="og:url" content="<?php
            if($_SERVER['HTTPS'] == 'on') {
				echo 'https';
			} else {
				echo 'http';
			}
			echo '://';
			
			echo $_SERVER['HTTP_HOST'];
			
			echo $_SERVER[PHP_SELF];
			
			if($_SERVER['QUERY_STRING'] <> '') {
				echo '?&'.$_SERVER['QUERY_STRING'];
			}
			?>"/>
            <meta property="og:site_name" content="<?=$infoSite->nome;?>"/>
            <meta property="article:publisher" content="<?=$infoSite->facebook;?>"/>
            <?php /*?><meta property="fb:admins" content="10153122431753681" /><?php */?>
            
			
			<?php
		}
		
		function select($nome, $id_selecionado, $dadosBD, $dadosExtras, $class) {
			echo("<select name='{$nome}' id='{$nome}' class='{$class}'>\n");
			//echo("<option value=''></option>\n"); // Cooca em dados extras.
			
			if($dadosExtras <> '') {
				$campos = explode(', ', $dadosExtras);
				sort($campos);

				foreach($campos as $campo) {
					$selecionado = '';
					if(retira_acentos($campo) == $id_selecionado) {
						$selecionado = "selected";
					}
					
					$value = retira_acentos($campo);
					if(strpos($campo, '**')) {
						$campo = str_replace('**','', $campo);
						$value = '';
					}
					
					echo("<option value='".$value."' {$selecionado}>{$campo}</option>\n");
				}
			}
			
			
			if($dadosBD <> '') {
				foreach($dadosBD as $dados) {
					$selecionado = '';
					if($dados->id == $id_selecionado) {
						$selecionado = "selected";
					}
					
					echo("<option value='".$dados->id."' {$selecionado}>{$dados->titulo}</option>\n");
				}
			}
			
			echo("</select>");
		}
		
		function campo($tipo, $nome, $valor) {
			?>
            <input type="<?=$tipo;?>" name="<?=$nome;?>" id="<?=$nome;?>" value="<?=$valor;?>">
            <?
		}
		
		function menuAdmin($id) { 
		
		if($id == 'newsletter') { ?>
        
        <li>
            <a href="cadastros-newsletter.php">
              <i class="fa fa-circle"></i>
              <span>Cadastros de Newsletter</span>
            </a>
        </li>
        <?  
		}
		
		if(is_numeric($id)) {
			global $MenusInstanciada;
			
			include('../class/menus.php');
			$menus = Menus::getInstance(Conexao::getInstance())->rsDados($id);
		?>
        <li>
            <a href="conteudos.php?idMenu=<?php echo $id;?>&tipo=conteudos">
              <i class="fa fa-circle"></i>
              <span><?php echo $menus->nome;?></span>
            </a>
        </li>
        <?php 
		}
		
		} 
		
		function formGroup($label, $nomeCampo, $valor='', $tipo='', $dadosSelect='', $obrigatorio='') {
			?>
            <div class="form-group">
                <label class="col-sm-2 control-label" >
					<?php 
					if($tipo == 'cor') { 
						?>
                        <div style="padding-top:10px;"><?php echo $label;?></div>
                        <?
					} elseif($tipo == 'checkbox') { 
					?>
                        <input name="<?=$nomeCampo?>" <?php if($dadosSelect == $valor) { echo 'checked'; } ?> type="checkbox" id="<?=$nomeCampo?>" value="<?php echo $valor;?>">
                        <?
					} else {
						echo $label;
					}?></label>
                <div class="col-sm-10">
                  <?php 
				  if($tipo == 'checkbox') { ?>
                  	<label style="padding-top:8px; margin-bottom:0px;" for="<?=$nomeCampo?>"><?php echo $label; ?></label>
				  <? 
				  } ?>
                  
				  <?php if($tipo == '' or $tipo == 'input') { ?>
                  <input name="<?=$nomeCampo?>" type="text" class="form-control" id="<?=$nomeCampo?>" value="<?php echo $valor;?>" <?php if($obrigatorio == 'S') { echo 'required'; } ?>>
                  <?php } ?>
                  
                  <?php if($tipo == 'cor') { ?>
                  <input name="<?=$nomeCampo?>" type="color" class="form-control" style="width:80px; height:50px;" id="<?=$nomeCampo?>" value="<?php echo $valor;?>" <?php if($obrigatorio == 'S') { echo 'required'; } ?>>
                  <?php } ?>
                  
                  <?php if($tipo == 'data' or $tipo == 'date') { ?>
                  <input name="<?=$nomeCampo?>" type="date" style="max-width:150px;" class="form-control" id="<?=$nomeCampo?>" value="<?php echo $valor;?>">
                  <?php } ?>
                  
                  <?php if($tipo == 'senha') { ?>
                  <input name="<?=$nomeCampo?>" type="password" class="form-control" id="<?=$nomeCampo?>" value="<?php echo $valor;?>">
                  <?php } ?>
                  
                  <?php if($tipo == 'textarea') { ?>
                  <textarea name="<?=$nomeCampo?>" id="<?=$nomeCampo?>" cols="30" rows="3" class="form-control" <?php if($obrigatorio == 'S') { echo 'required'; } ?>><?php echo $valor;?></textarea>
                  <?php } ?>
                  
                  <?php if($tipo == 'arquivo') { ?>
                  <input name="<?=$nomeCampo?>" type="file" class="form-control" id="<?=$nomeCampo?>">
                  <input type="hidden" name="<?=str_replace('[]', '', $nomeCampo)?>_Atual<?php if(strpos($nomeCampo, '[]')) { echo '[]'; } ?>" value="<?php echo $valor;?>">
                  <?php } ?>
                  
                  <?php 
				  if($tipo == 'select') {
					  $this->select($nomeCampo, $valor, $dadosSelect, $dadosExtras, 'form-control');
				  } ?>
                  
                  <?php if($tipo == 'botoesEnviar') { ?>
                  <button class="btn btn-primary mr10" type="submit">Confimar</button>
                  <button class="btn btn-default" type="button" onClick="history.back();">Voltar</button>
                  <? } ?>
                  
                </div>
              </div>
            <?
		}
	}
	
	$HTMLInstanciada = 'S';
}