<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php';
    include './inc/conexao.php'; 

    $tipo = @$_POST["relatorio"];
    $valor = @$_POST["valor"];

    if ($tipo=='R'){
      $sql = "select id,nome as Crianca from crianca where cpf_responsavel = '".$valor."' and deletado='N'";
      $rel_tipo = "Responsável ".$valor;
    }
    if ($tipo=='E'){
      $sql = "select c.id,c.nome as Crianca from crianca as c
      inner join escola e on c.id_escola=e.id and e.nome like '%".$valor."%' and e.deletado='N' where c.deletado='N'";
      $rel_tipo = "Escola ".$valor;
    }
    if ($tipo=='P'){
      if ($valor){
        $sql = "select distinct c.id,c.nome as Crianca from crianca as c
        inner join criancatrecho ct on c.id = ct.id_crianca and ct.deletado='N'
        where ct.periodo_conducao = '".$valor."' and c.deletado='N' ";
      } else {
        $sql = "select distinct c.id,c.nome as Crianca from crianca as c
        inner join criancatrecho ct on c.id = ct.id_crianca and ct.deletado='N'
        where c.deletado='N' ";
      }

      if ($valor == 'im')
        $rel_tipo = "Período da Ida-Manhã";
      if ($valor == 'it')
        $rel_tipo = "Período da Ida-Tarde";
      if ($valor == 'vm')
        $rel_tipo = "Período da Volta-Manhã";
      if ($valor == 'vt')
        $rel_tipo = "Período da Volta-Tarde";
      if ($valor == "") 
        $rel_tipo = "Todos os períodos";
    }

    if ($tipo=='V'){
      $sql = "select distinct c.id,c.nome as Crianca from crianca c
      inner join criancatrecho ct on c.id = ct.id_crianca and ct.deletado='N'
      where ct.placa_veiculo like '%".$valor."%' and c.deletado='N'";
      $rel_tipo = "Veículo ".$valor;
    }

    $result = $conexao->query($sql);

?>  
<div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Relatorio</li>
          <li class="active">Crianca</li>
        </ol>
      </div>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="row imprime">
                  <div class="col-lg-6">
                    <h1 class="page-header imprime">Crianças do <?php print $rel_tipo;?></h1>
                  </div>
                  <div class="col-lg-6">
                    <button class="btn-criar nao-imprime" id="print">Imprimir</button>
                  </div>
                </div>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="80%">
                      <p class="formu-letra">Nome</p>
                    </td>
                    <td width="20%">
                    </td>
                </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td width="80%">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </td>
                      <td class="nao-imprime" width="20%">
                        <a href="ver_mais_crianca.php?id=<?php print $row['id'];?>">Ver mais</a>
                      </td>
                  </tr>
                <?php } ?>
              </table>              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#print").click(function(){
        window.print();
      });
    });

  </script>

<?php } ?>
