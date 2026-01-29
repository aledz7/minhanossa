<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'provas.php';

include('rs-ponto.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Imprimir - Folha de Ponto</title>
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php if($totalRows_rs_ponto > 0) { ?>
          <table width="100%" class="table table-bordered">
           
            <tbody>
              
              <tr>
                <td width="13%" style="text-align:center"><strong>Dia</strong></td>
                <td width="12%" style="text-align:center"><strong>Chegada</strong></td>
                <td width="17%" style="text-align:center" ><strong>Sa&iacute;da Almo&ccedil;o</strong></td>
                <td width="17%" style="text-align:center"><strong>Chegada Almo&ccedil;o</strong></td>
                <td width="11%" style="text-align:center"><strong>Sa&iacute;da</strong></td>
                <td width="17%" style="text-align:center"><strong>Horas Trabalhadas</strong></td>
              </tr>
            
            <?php
			if($totalRows_rs_ponto > 0){
			 do {
				 $manhaSegs = hora_to_seg($row_rs_relatorio['Hs Saida almoco'])-hora_to_seg($row_rs_relatorio['hora Chegada']);
				$tardeSegs = hora_to_seg($row_rs_relatorio['hs saida'])-hora_to_seg($row_rs_relatorio['hs chegada almoco']);
				$tempoTrabalhado = $manhaSegs+$tardeSegs;
		     ?>
              <tr>
                <td style="text-align:center"><?php echo formataData($row_rs_ponto['chegada']);?></td>
                <td style="text-align:center"><?php echo substr($row_rs_ponto['chegada'],11,8);?></td>
                <td style="text-align:center" ><?php echo substr($row_rs_ponto['saida_almoco'],11,8);?></td>
                <td style="text-align:center"><?php echo substr($row_rs_ponto['chegada_almoco'],11,8);?></td>
                <td style="text-align:center"><?php echo substr($row_rs_ponto['saida'],11,8);?></td>
                <td style="text-align:center"><?php echo m2h($tempoTrabalhado/60);?></td>
              </tr>
             
            <?php }while($row_rs_ponto = mysql_fetch_assoc($rs_ponto)); ?>
             
              <?php
			}
			?>
              
            </tbody>
          </table>
          <?php 
		  } else { 
		  	$HTML->nenhumRegistro("Nenhum registro encontrado. Por favor, realize uma busca.");
		  }
		  ?>
<script>
print();
setTimeout(function(){ parent.window['temp_' + <?php echo $_GET['janela'];?>].close(); }, 1000);
</script>
</body>
</html>