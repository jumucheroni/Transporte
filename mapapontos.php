<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
  define('INFI',9999999999);
    include './inc/header.php';
    include './inc/conexao.php';

    $tipo = @$_POST["relatorio"];
    $periodo = @$_POST["periodo"];
    $veiculo = @$_POST["veiculo"];
    $escolas = @$_POST["escola"];

    $escolas = json_decode($escolas);

    if ($periodo == 'm') {
      $periodo_conducao = " and ct.periodo_conducao in ('im')"; 
      $periodo_condutor = " and cv.periodo in ('im')"; 
      $titulo_mapa = "Periodo ida-manhã";
    } 
    if ($periodo == "a") {
      $periodo_conducao = " and ct.periodo_conducao in ('vm','it')"; 
      $periodo_condutor = " and cv.periodo in ('vm','it')"; 
      $titulo_mapa2 = "Periodo volta-manhã";
      $titulo_mapa = "Periodo ida-tarde";
    }
    if ($periodo == "t") {
      $periodo_conducao = " and ct.periodo_conducao in ('vt')"; 
      $periodo_condutor = " and cv.periodo in ('vt')";
      $titulo_mapa = "Periodo volta-tarde"; 
    }

   $enderecos = array();
   $enderecos2 = array();

    if ($tipo == "E") {
        $valor = @$_POST['valor'];

        $whereescolas = "";
        foreach ($valor as $escola) {
          $whereescolas .= $escola.",";
        }
        $tame = strlen($whereescolas);
        $whereescolas = substr($whereescolas,0, $tame-1);

        $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,  
        CONCAT(t.cep_origem,',',t.logradouro_origem,',',t.numero_origem,',',t.cidade_origem,',',t.estado_origem) as origem,
        CONCAT(t.cep_destino,',',t.logradouro_destino,',',t.numero_destino,',',t.cidade_destino,',',t.estado_destino) as destino, t.id_escola as escola,c.nome as crianca from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho
        where ct.deletado ='N'".$periodo_conducao." and t.id_escola in (".$whereescolas.") and v.placa = '".$veiculo."'";
        $result = $conexao->query($sql);
    }

    if ($tipo == "T") {

        $whereescolas = "";
        foreach ($escolas as $key => $value) {
          $whereescolas .= $value.",";
        }
        $tame = strlen($whereescolas);
        $whereescolas = substr($whereescolas,0, $tame-1);

        $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,  
        CONCAT(t.cep_origem,',',t.logradouro_origem,',',t.numero_origem,',',t.cidade_origem,',',t.estado_origem) as origem,
        CONCAT(t.cep_destino,',',t.logradouro_destino,',',t.numero_destino,',',t.cidade_destino,',',t.estado_destino) as destino,t.id_escola as escola,c.nome as crianca from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho
        where ct.deletado ='N'".$periodo_conducao." and v.placa = '".$veiculo."' and t.id_escola in (".$whereescolas.")
        order by c.id_escola";
        $result = $conexao->query($sql);
    }

        $sqlveiculo = "select cpf_ajudante, lotacao from veiculo where placa = '".$veiculo."'";
        $resultveiculo = $conexao->query($sqlveiculo);
        $rowveiculo = @mysqli_fetch_array($resultveiculo);

        $enderecos = array();
        $enderecosescolas = array();
        $enderecos2escolas = array();
        $cont  = 0;
        $cont2 = 0;
        $contfinal = 0;
        $cont2final = 0;

      if ($result->num_rows){

        if ($rowveiculo['cpf_ajudante']) {

            $sqlajudante = "select CONCAT(cep,',',logradouro,',',numero,',',cidade,',',estado) as ajudante,nome,email from ajudante where cpf = '".$rowveiculo['cpf_ajudante']."'";
            $resultajudante = $conexao->query($sqlajudante); 

            $rowajudante = @mysqli_fetch_array($resultajudante);
            $address_ajudante = urlencode($rowajudante['ajudante']);
            $request_url_ajudante = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_ajudante."&sensor=false";
             $status_ajudante = @file_get_contents($request_url_ajudante);
            $data_ajudante = json_decode($status_ajudante,true);
            $LatLng_ajudante = "";
            if ($data_ajudante){
                $Lat_ajudante = $data_ajudante['results'][0]['geometry']['location']['lat'];
                $Lon_ajudante = $data_ajudante['results'][0]['geometry']['location']['lng'];
                $LatLng_ajudante = $Lat_ajudante.",".$Lon_ajudante;
            }
        }
       
            $sqlcondutor = "select CONCAT(c.cep,',',c.logradouro,',',c.numero,',',c.cidade,',',c.estado) as condutor,c.nome,c.email from condutor c INNER JOIN condutorveiculo cv ON cv.cpf_condutor = c.cpf where cv.placa_veiculo = '".$veiculo."'".$periodo_condutor;
            $resultcondutor = $conexao->query($sqlcondutor);
            $rowcondutor = @mysqli_fetch_array($resultcondutor);
            $address_condutor = urlencode($rowcondutor['condutor']);
            $request_url_condutor = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_condutor."&sensor=false";
             $status_condutor = @file_get_contents($request_url_condutor);
            $data_condutor = json_decode($status_condutor,true);
            $LatLng_condutor = "";
            if ($data_condutor){
                $Lat_condutor = $data_condutor['results'][0]['geometry']['location']['lat'];
                $Lon_condutor = $data_condutor['results'][0]['geometry']['location']['lng'];
                $LatLng_condutor = $Lat_condutor.",".$Lon_condutor; 
            }

          $sqlescola = "select CONCAT(e.cep,',',e.logradouro,',',e.numero,',',e.cidade,',',e.estado) as escola, e.id,e.nome,entrada_manha,saida_manha,entrada_tarde,saida_tarde from escola e 
           inner join trecho t on t.id_escola = e.id
           inner join criancatrecho ct on t.id = ct.id_trecho
            where ct.deletado ='N'".$periodo_conducao." and e.id in (".$whereescolas.") group by e.id";
          $resultescola = $conexao->query($sqlescola);
          while ($rowescola = @mysqli_fetch_array($resultescola)) {
              $address_escola = urlencode($rowescola['escola']);
                $request_url_escola = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_escola."&sensor=false";
                 $status_escola = @file_get_contents($request_url_escola);
                $data_escola = json_decode($status_escola,true);
                $LatLng_escola = "";
                if ($data_escola){
                    $Lat_escola = $data_escola['results'][0]['geometry']['location']['lat'];
                    $Lon_escola = $data_escola['results'][0]['geometry']['location']['lng'];
                    $LatLng_escola = $Lat_escola.",".$Lon_escola;
                }
                $enderecosescolas[$contfinal] = [
                  'origem' => $LatLng_escola,
                  'destino' => $LatLng_escola,
                  'escola' => $rowescola["id"],
                  'completo' => $rowescola['nome']." - ".$rowescola['escola'],
                  'horario' => [
                    "0" => $rowescola['entrada_manha'],
                    "1" => $rowescola['saida_manha'],
                    "2" => $rowescola['entrada_tarde'],
                    "3" => $rowescola['saida_tarde']
                  ]
                ];
              if ($periodo == 'a') {
                $enderecos2escolas[$cont2final] = [
                  'origem' => $LatLng_escola,
                  'destino' => $LatLng_escola,
                  'escola' => $rowescola["id"],
                  'completo' => $rowescola['nome']." - ".$rowescola['escola'],
                  'horario' => [
                    "0" => $rowescola['entrada_manha'],
                    "1" => $rowescola['saida_manha'],
                    "2" => $rowescola['entrada_tarde'],
                    "3" => $rowescola['saida_tarde']
                  ]
                ];
                $cont2final++;
              }

              $contfinal++;
          }      
        
          $enderecos[$cont] = [
            'origem' => $LatLng_condutor,
            'destino' => $LatLng_condutor,
            'tipo' => 0,
            'escola' => 0,
            'completo' => $rowcondutor['nome']." - ".$rowcondutor['condutor']
          ];

          if ($LatLng_ajudante) {
            $cont++;
            $enderecos[$cont] = [
              'origem' => $LatLng_ajudante,
              'destino' => $LatLng_ajudante,
              'tipo' => 0,
              'escola' => 0,
              'completo' => $rowajudante['nome']." - ".$rowajudante['ajudante']
            ];
          }

          $cont++;

        while ($row = @mysqli_fetch_array($result)) {
            $address_origem = urlencode($row['origem']);
            $request_url_origem = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_origem."&sensor=false";
             $status_origem = @file_get_contents($request_url_origem);
            $data_origem = json_decode($status_origem,true);
            $LatLng_origem = "";
            if ($data_origem){
                $Lat_origem = $data_origem['results'][0]['geometry']['location']['lat'];
                $Lon_origem = $data_origem['results'][0]['geometry']['location']['lng'];
                $LatLng_origem = $Lat_origem.",".$Lon_origem;
            }

            $address_destino = urlencode($row['destino']);
            $request_url_destino = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&address=".$address_destino."&sensor=false";
             $status_destino = @file_get_contents($request_url_destino);
            $data_destino = json_decode($status_destino,true);
            $LatLng_destino = "";
            if ($data_destino){
                $Lat_destino = $data_destino['results'][0]['geometry']['location']['lat'];
                $Lon_destino = $data_destino['results'][0]['geometry']['location']['lng'];
                $LatLng_destino = $Lat_destino.",".$Lon_destino;
            }

            if ($periodo == "a" && $row["Tipo"] == 'vm') {
              $enderecos2[$cont2] = [
                'origem' => $LatLng_origem,
                'destino' => $LatLng_destino,
                'tipo' => $row["Tipo"],
                'escola' => $row["escola"],
                'completo' => $row['crianca']." - ".$row['destino']
              ];
              $cont2++;
              $criancaescolav[] = [
                  'escola' => $row["escola"]
              ];
            } else {
              if ($row['Tipo'] == 'vt') {
                $enderecos[$cont] = [
                  'origem' => $LatLng_origem,
                  'destino' => $LatLng_destino,
                  'tipo' => $row["Tipo"],
                  'escola' => $row["escola"],
                  'completo' => $row['crianca']." - ".$row['destino']
                ];
                $criancaescolav[] = [
                  'escola' => $row["escola"]
                ];
              } else {
                $enderecos[$cont] = [
                  'origem' => $LatLng_origem,
                  'destino' => $LatLng_destino,
                  'tipo' => $row["Tipo"],
                  'escola' => $row["escola"],
                  'completo' => $row['crianca']." - ".$row['origem']
                ];
                $criancaescolai[] = [
                  'escola' => $row["escola"]
                ];
              }
              $cont++;
            }  
        } 
      }
      for ($i = 0; $i < sizeof($enderecos); $i++) {
        if ($enderecos[$i]['tipo'] == 'vm' || $enderecos[$i]['tipo'] == 'vt') {
          $pontos[$i]['endereco'] = $enderecos[$i]["destino"];
        } else {
          $pontos[$i]['endereco'] = $enderecos[$i]["origem"];
        }
        $pontos[$i]['completo'] = $enderecos[$i]["completo"];
        if (isset($enderecos[$i]['escola'])) {
          $pontos[$i]['escola'] = $enderecos[$i]['escola'];
        } else {
          $pontos[$i]['escola'] = 0;
        }
        $pontos[$i]['tipo'] = $enderecos[$i]["tipo"];
      } 
      for ($i = 0; $i < sizeof($enderecosescolas); $i++){
        $pontosfinal[$i]['endereco'] = $enderecosescolas[$i]["origem"];
        $pontosfinal[$i]['escola'] = $enderecosescolas[$i]['escola'];
        $pontosfinal[$i]['completo'] = $enderecosescolas[$i]["completo"];
        $pontosfinal[$i]['isescola'] = true;
      }


      if ($periodo == 'a') {

        for ($i = 0; $i < sizeof($enderecos2); $i++) {
          if ($enderecos2[$i]['tipo'] == 'vm' || $enderecos2[$i]['tipo'] == 'vt') {
            $pontos2[$i]['endereco'] = $enderecos2[$i]["destino"];
          } else {
            $pontos2[$i]['endereco'] = $enderecos2[$i]["origem"];
          }   
          $pontos2[$i]['completo'] = $enderecos2[$i]["completo"];
          if (isset($enderecos2[$i]['escola'])) {
            $pontos2[$i]['escola'] = $enderecos2[$i]['escola'];
          }
          $pontos2[$i]['tipo'] = $enderecos2[$i]["tipo"];
        } 
        for ($i = 0; $i < sizeof($enderecosescolas); $i++){
          $pontosfinal2[$i]['endereco'] = $enderecos2escolas[$i]["origem"];
          $pontosfinal2[$i]['escola'] = $enderecos2escolas[$i]['escola'];
          $pontosfinal2[$i]['completo'] = $enderecos2escolas[$i]["completo"];
          $pontosfinal2[$i]['isescola'] = true;
        } 
               
      }
        if (isset($pontos)) {
          $arrpontos = $pontos;
          $pontos = json_encode($pontos);
          $arrpontosfinal = $pontosfinal;
          $pontosfinal = json_encode($pontosfinal);
          $arrpontoscompleto = array_merge($arrpontos,$arrpontosfinal);

          $enderecosescolas = json_encode($enderecosescolas);
          $enderecos2escolas = json_encode($enderecos2escolas);
        }
        if (isset($pontos2)) {
          $arrpontos2 = $pontos2;
          $pontos2 = json_encode($pontos2);
          $arrpontosfinal2 = $pontosfinal2;
          $pontosfinal2 = json_encode($pontosfinal2);
          $arrpontoscompleto = array_merge($arrpontoscompleto,$arrpontos2);
        }

        if (isset($criancaescolav)) {
          $criancaescolav = json_encode($criancaescolav);
        }
        if (isset($criancaescolai)) {
          $criancaescolai = json_encode($criancaescolai);
        }

?>        
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Mapa de Pontos</li>
              </ol>
            </div>
        <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
            <input type="hidden" id="pontos" value='<?php if (isset($pontos)) echo $pontos; else echo "" ; ?>'/>
            <input type="hidden" id="pontos2" value='<?php  if (isset($pontos2)) echo $pontos2; else echo "" ; ?>'/>
            <input type="hidden" id="pontosfinal" value='<?php if (isset($pontosfinal)) echo $pontosfinal; else echo "" ; ?>'/>
            <input type="hidden" id="pontosfinal2" value='<?php if (isset($pontosfinal2)) echo $pontosfinal2; else echo "" ; ?>'/>
            <input type="hidden" id="enderecosescolas" value='<?php if (isset($enderecosescolas)) echo $enderecosescolas; else echo "" ; ?>'/>
            <input type="hidden" id="enderecos2escolas" value='<?php if (isset($enderecos2escolas)) echo $enderecos2escolas; else echo "" ; ?>'/>
            <input type="hidden" id="condutor" value='<?php if (isset($rowcondutor["email"])) echo $rowcondutor["email"]; else echo "" ; ?>' />
            <input type="hidden" id="ajudante" value='<?php if (isset($rowajudante["email"])) echo $rowajudante["email"]; else echo "" ; ?>' />
            <input type="hidden" id="periodo" value= '<?php echo $periodo;?>'/>
            <input type="hidden" id="lotacao" value= '<?php echo $rowveiculo["lotacao"];?>'/>
            <input type="hidden" id="criancaescolai" value = '<?php if (isset($criancaescolai)) echo $criancaescolai; else echo "";?>' />
            <input type="hidden" id="criancaescolav" value = '<?php if (isset($criancaescolav)) echo $criancaescolav; else echo ""; ?>' />
            <h1 class="page-header">Mapa</h1>
        <?php if (isset($pontos)) { ?>
          <h3 class="page-header"><?php print $titulo_mapa; ?></h3>
				  <div id="map" style="height: 500px"></div>
        <?php } ?>
        <?php if (isset($pontos2)) { ?>
          <h3 class="page-header"><?php print $titulo_mapa2; ?></h3>
          <div id="map2" style="height: 500px"></div>
        <?php } ?>
        <?php if (!isset($pontos)) { ?>
            <div id="erro"> 
              <h2>Não há transportes a ser realizado para estes dados</h2>
            </div>
        <?php } ?>
        <?php if (isset($pontos)) { ?>
          <div id= "cenderecos"> 
            <h3>Criar Roteiro</h3>
              <p>
                Escolha um endereço e adicione, caso necessario comece novamente: 
                <select class="input-formu" id="combo" name="combo" >
                  <?php foreach ($arrpontoscompleto as $key => $value) { 
                    if (isset($value['isescola'])) { ?>
                    <option value="<?php print $key.'_'.$value['escola'];?>" id="<?php print $key;?>" ><?php print $value['completo'];?></option>
                  <?php } else { ?>
                    <option value="<?php print $key.'_0_'.$value['escola'].'_'.$value['tipo'];?>" id="<?php print $key;?>" ><?php print $value['completo'];?></option>
                  <?php } }?>
                </select>
                <button class="btn btn-success " id="adicionar" type="button">Adicionar</button>
                <button class="btn btn-warning " id="remover" type="button">Recomeçar</button>
              </p>
              <div id="roteiro">
                
              </div>
              <h3 class="page-header">Roteiro Detalhado </h3>
              <div id="pdf">
                <div id="maproteiros" style="height: 500px"></div>
                <div id="panel"></div>
              </div>
              <div id="show_img"></div>
              <div class = "row">
                <h5 class="page-header">Preencha o assunto e a mensagem do email para exportar, caso não preencha será enviado sem assunto e sem mensagem.</h5>
                <div class="col-md-4" >
                   <p> Assunto: <input class="form-control" type="text" name="assunto" id="assunto" value="" /></p>
                  </div>
                <div class="col-md-4" >
                  <p>Mensagem: <input class="form-control" type="textarea" name="corpo" id="corpo" value="" /></p>
                </div>
                <div class="col-md-4" >
                  <button style="float: right;" class="btn btn-info" type="button" name="epdf" id="epdf">Exportar e enviar por email</button>
                </div>
              </div>
          </div>
        <?php } ?>
			</div>
		</div>

<?php include './inc/footer.php'; ?>
<script src="js/itinerario.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&callback=initMap"
    async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">

function initMap() {
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var colors = ['red','green','purple','yellow','blue','pink'];
var pinColor = ['000080','FFFF00','00CED1','CD5C5C','006400','2E8B57']
var labelIndex = 0;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var infowindow = new google.maps.InfoWindow();

var pontos = $("#pontos").val();
var pontosfinal = $("#pontosfinal").val();
if (pontos) {
  pontos = jQuery.parseJSON(pontos);
}
if (pontosfinal) {
  pontosfinal = jQuery.parseJSON(pontosfinal);
}
  directionsDisplay = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "blue"
    }, suppressMarkers: true
  });

if (pontos.length){
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(-22.331980, -49.029568),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay.setMap(map);

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };

  var escolacolor = {}; 

  var tamanhoescola = Object.keys(pontosfinal).length;
  for (i = 0; i < tamanhoescola; i++) {
    var ponto = pontosfinal[i]["endereco"].split(",");
    var escola = pontosfinal[i]["escola"];
    escolacolor[escola] = pinColor[i+1];
    var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + escolacolor[pontosfinal[i]["escola"]],
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
      map: map,
      icon: pinImage
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(pontosfinal[i]["completo"]);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }

  var tamanho = Object.keys(pontos).length;
  for (i = 0; i < tamanho; i++) {
    var ponto = pontos[i]["endereco"].split(",");
    var color = "";
    if (typeof escolacolor[pontos[i]["escola"]] != "undefined") {
      color = escolacolor[pontos[i]["escola"]] ;
    } else {
      color = pinColor[0];
    }
    var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + color,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
      map: map,
      icon: pinImage
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(pontos[i]["completo"]);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }
}

var directionsDisplay2;
var directionsService2 = new google.maps.DirectionsService();

var pontos2 = $("#pontos2").val();
var pontosfinal2 = $("#pontosfinal2").val();
if (pontos2) {
  pontos2 = jQuery.parseJSON(pontos2);
}
if (pontosfinal2) {
  pontosfinal2 = jQuery.parseJSON(pontosfinal2);
}
  directionsDisplay2 = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "blue"
    }, suppressMarkers: true
  });

if (pontos2.length){
  var map = new google.maps.Map(document.getElementById('map2'), {
    zoom: 10,
    center: new google.maps.LatLng(-22.331980, -49.029568),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay2.setMap(map);

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };

  var escolacolor2 = {}; 

  var tamanhoescola = Object.keys(pontosfinal2).length;
  for (i = 0; i < tamanhoescola; i++) {
    var ponto = pontosfinal2[i]["endereco"].split(",");
    var escola = pontosfinal2[i]["escola"];
    escolacolor2[escola] = pinColor[i+1];
    var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + escolacolor[pontosfinal[i]["escola"]],
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
      map: map,
      icon: pinImage
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(pontosfinal2[i]["completo"]);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }

  var tamanho = Object.keys(pontos2).length;
  for (i = 0; i < tamanho; i++) {
    var ponto = pontos2[i]["endereco"].split(",");
     var color = "";
    if (typeof escolacolor2[pontos2[i]["escola"]] != "undefined") {
      color = escolacolor2[pontos2[i]["escola"]] ;
    } else {
      color = pinColor[0];
    }
    var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + color,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
      map: map,
      icon: pinImage
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(pontos2[i]["completo"]);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }
}
}
</script>


<?php } 

    /**/?>





