<?php

/**
* Plugin Name: Cadastro.
* Description: 
* Version: 1.0
* Author: Anna Luíza Correia Serrano.   3MIN1.
*/





function cadastro_create_table(){
global $wpdb;




$nomeDaTabela = $wpdb->prefix . 'cd_cadastro';



if ($wpdb->get_var("SHOW TABLES LIKE '$nomeDaTabela'")) != $nomeDaTabela {
$sql = "
CREATE TABLE $nomeDaTabela(
cd_cadastro int auto_increment primary key,
nm_cadastro varchar(100),
dt_nascimento date,
ds_relatorio varchar(200)
 );
";




require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
dbDelta($sql); 
}
}




add_action('init', 'cadastro_create_table');



function cadastro_menu(){
add_menu_page('Cadastro de pessoa', 'Cad. de pessoa', 'manage_option', 'cadastro-pessoa', 'formulario_cad_pessoa', 'dashicons-format-aside', 100);
add_menu_page('Editar usuario', 'Edt. Usuario', 'manage_options', 'editar-cadastro', 'editar_cadastro', 'dashicons-format-aside', 101);
}





add_action('admin-menu', 'cadastro_create_table');

function formulario_cad_pessoa(){
?>






<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="row">
<div class="col-12">
<h1>Cadastro</h1>
</div>
</div>





<form action="" method="post">
<div class="row">
<div class="col-8">
<div class="form-group">
<label for="">Nome: </label>
<input type="text" class="form-control" name="nome">
</div>
</div>
</div>




<div class="row">
<div class="col-4">
<div class="form-group">
<label for="">Data de nascimento: </label>
<input type="date" class="form-control" name="data">
</div>
</div>
</div>



<div class="row">
<div class="col-8">
<div class="form-group">
<label for="">Relatório: </label>
<textarea class="form-control" rows='10' name="relatorio"></textarea>
</div>
</div>
</div>





<div class="row">
<div class="col-12">
<div class="form-group">
<button class="btn btn-success btn-block" type="submit" name="enviarCadastro">Enviar</button>
</div>
</div>
</div>



</form>




<?php


global $wpdb;
$nomeDaTabela = $wpdb->prefix . 'cd_cadastro';




if (isset($_POST['enviarCad'])) {
$nome = sanitize_text_field($_POST['nome']);
$data = sanitize_text_field($_POST['data']);
$relatorio = sanitize_text_field($_POST['relatorio']);




$wpdb->insert($nomeDaTabela, array(
'nm_cadastro'=>$nome,
'dt_nascimento'=>$data,
'ds_relatorio'=>$relatorio
));
echo 'Cadastro efetuado com sucesso';



}else{
echo "Erro ao cadastrar";
}
}





function editar_cadastrar(){
global $wpdb;
$resultado = $wpdb->get_results("SELECT cd_cadastro, nm_cadastro, DATE_FORMAT(dt_nascimento, '%d/%m/%Y') as data, ds_relatorio FROM wp_cd_cadastro");
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


      
<div class="row">
<div class="col-12">
<h1>LISTA DE PESSOAS</h1>
</div>
</div>


<div class="row">
<div class="col-12">
<table class="table">

<tr>


<td>Cod.</td>
<td>Nome</td>
<td>Data Nasc.</td>
<td>Relatório</td>
<td>Ação</td>
</tr>

 <?php
 foreach($resultado as $key => $valor){   
?>
                
<tr>


<td><?=$valor->cd_usuario?></td>
<td><?=$valor->nm_usuario?></td>
<td><?=$valor->data?></td>
<td><?=$valor->ds_relatorio?></td>
<td>



<form method="post">
<input type="hidden" value="<?=$valor->cd_cadastro?>" name="id">
<button type="submit" class="btn btn-block btn-danger" value="excluir" name="excluir">Excluir</button>
</form>
</td>


</tr>



<?php
} 
?>               
</table>
</div>
</div>





<?php
if (!empty($_POST['excluir'])) {
$id = santize_text_field($_POST['id']);
$wpdb->delete('wp_cd_cadastro', array('cd_cadastro'=>$id));
?>




<script language="javascript" type="text/javascript">
function atualiza(){
alert("Registro removido");
document.location.reload(true);
}
atualiza();
</script>




<?php
}
}



function listarFront(){
global $wpdb;
$resultado = $wpdb->get_results("SELECT cd_cadastro, nm_cadastro, DATE_FORMAT(dt_nascimento, '%d/%m/%Y') as data, ds_relatorio FROM wp_cd_cadastro");
?>


      
<div class="row">
<div class="col-12">
<h3>LISTA DE PESSOAS</h3>
</div>
</div>




<div class="row">
<div class="col-12">
<table class="table">
<tr>


<td>Cod.</td>
<td>Nome</td>
<td>Data Nasc.</td>
<td>Relatório</td>
</tr>

                
<?php
foreach($resultado as $key => $valor){   
?>


                
<tr>


<td><?=$valor->cd_usuario?></td>
<td><?=$valor->nm_usuario?></td>
<td><?=$valor->data?></td>
<td><?=$valor->ds_relatorio?></td>
</tr>


<?php
} 
?>               
</table>
</div>
</div>
<?php


}



add_shortcode('listarFront', 'listarFront');