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
    } 
    if ($periodo == "a") {
      $periodo_conducao = " and ct.periodo_conducao in ('vm','it')"; 
      $periodo_condutor = " and cv.periodo in ('vm','it')"; 
    }
    if ($periodo == "t") {
      $periodo_conducao = " and ct.periodo_conducao in ('vt')"; 
      $periodo_condutor = " and cv.periodo in ('vt')"; 
    }

   $enderecos = array();
   $enderecos2 = array();

    if ($tipo == "E") {
        $valor = @$_POST['valor'];

        $whereescolas = $valor;

        $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,  
        CONCAT(t.cep_origem,',',t.logradouro_origem,',',t.numero_origem,',',t.cidade_origem,',',t.estado_origem) as origem,
        CONCAT(t.cep_destino,',',t.logradouro_destino,',',t.numero_destino,',',t.cidade_destino,',',t.estado_destino) as destino, t.id_escola as escola,c.nome as crianca from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho
        where ct.deletado ='N'".$periodo_conducao." and t.id_escola = ".$valor." and v.placa = '".$veiculo."'";
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

        $sqlveiculo = "select cpf_ajudante from veiculo where placa = '".$veiculo."'";
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

            $sqlajudante = "select CONCAT(cep,',',logradouro,',',numero,',',cidade,',',estado) as ajudante,nome from ajudante where cpf = '".$rowveiculo['cpf_ajudante']."'";
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
       
            $sqlcondutor = "select CONCAT(c.cep,',',c.logradouro,',',c.numero,',',c.cidade,',',c.estado) as condutor,c.nome from condutor c INNER JOIN condutorveiculo cv ON cv.cpf_condutor = c.cpf where cv.placa_veiculo = '".$veiculo."'".$periodo_condutor;
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

          $sqlescola = "select CONCAT(e.cep,',',e.logradouro,',',e.numero,',',e.cidade,',',e.estado) as escola, e.id,e.nome from escola e 
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
                  'completo' => $rowescola['nome']." - ".$rowescola['escola']
                ];
              if ($periodo == 'a') {
                $enderecos2escolas[$cont2final] = [
                  'origem' => $LatLng_escola,
                  'destino' => $LatLng_escola,
                  'escola' => $rowescola["id"],
                  'completo' => $rowescola['nome']." - ".$rowescola['escola']
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
            } else {
              if ($row['Tipo'] == 'vt') {
                $enderecos[$cont] = [
                  'origem' => $LatLng_origem,
                  'destino' => $LatLng_destino,
                  'tipo' => $row["Tipo"],
                  'escola' => $row["escola"],
                  'completo' => $row['crianca']." - ".$row['destino']
                ];
              } else {
                $enderecos[$cont] = [
                  'origem' => $LatLng_origem,
                  'destino' => $LatLng_destino,
                  'tipo' => $row["Tipo"],
                  'escola' => $row["escola"],
                  'completo' => $row['crianca']." - ".$row['origem']
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
      } 
      for ($i = 0; $i < sizeof($enderecosescolas); $i++){
        $pontosfinal[$i]['endereco'] = $enderecosescolas[$i]["origem"];
        $pontosfinal[$i]['escola'] = $enderecosescolas[$i]['escola'];
        $pontosfinal[$i]['completo'] = $enderecosescolas[$i]["completo"];
      }


      if ($periodo == 'a') {

        for ($i = 0; $i < sizeof($enderecos2); $i++) {
          if ($enderecos2[$i]['tipo'] == 'vm' || $enderecos2[$i]['tipo'] == 'vt') {
            $pontos2[$i]['endereco'] = $enderecos2[$i]["destino"];
          } else {
            $pontos2[$i]['endereco'] = $enderecos2[$i]["origem"];
          }   
          $pontos2[$i]['completo'] = $enderecos2[$i]["completo"];
          if (isset($enderecos[$i]['escola'])) {
            $pontos2[$i]['escola'] = $enderecos2[$i]['escola'];
          }
        } 
        for ($i = 0; $i < sizeof($enderecosescolas); $i++){
          $pontosfinal2[$i]['endereco'] = $enderecos2escolas[$i]["origem"];
          $pontosfinal2[$i]['escola'] = $enderecos2escolas[$i]['escola'];
          $pontosfinal2[$i]['completo'] = $enderecos2escolas[$i]["completo"];
        } 
               
      }
        if (isset($pontos)) {
          $arrpontos = $pontos;
          $pontos = json_encode($pontos);
          $arrpontosfinal = $pontosfinal;
          $pontosfinal = json_encode($pontosfinal);
          $arrpontoscompleto = array_merge($arrpontos,$arrpontosfinal);
        }
        if (isset($pontos2)) {
          $pontos2 = json_encode($pontos2);
          $pontosfinal2 = json_encode($pontosfinal2);
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
            <h1 class="page-header">Mapa</h1>
        <?php if (isset($pontos)) { ?>
				  <div id="map" style="height: 500px"></div>
        <?php } ?>
        <?php if (isset($pontos2)) { ?>
          <div id="map2" style="height: 500px"></div>
        <?php } ?>
        <?php if (!isset($pontos)) { ?>
            <div id="erro"> 
              <h2>Não há transportes a ser realizado para estes dados</h2>
            </div>
        <?php } ?>
        <div id= "cenderecos"> 
          <h3>Criar Roteiro</h3>
            <p>
              Escolha um endereço e adicione ou exclua para montar o roteiro: 
              <select class="input-formu" id="combo" name="combo" >
                <?php foreach ($arrpontoscompleto as $key => $value) {;?>
                  <option value="<?php print $key?>" id="<?php print $key;?>" ><?php print $value['completo'];?></option>
                <?php } ?>
              </select>
              <button class="btn btn-success " id="adicionar" type="button">Adicionar</button>
              <button class="btn btn-danger " id="remover" type="button">Remover</button>
            </p>
            <div id="roteiro">
              
            </div>
          <div id="maproteiros" style="height: 500px"></div>
        </div>
        <div id="right-panel"></div>
			</div>
		</div>

<?php include './inc/footer.php'; ?>
<script src="js/itinerario.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&callback=initMap"
    async defer></script>
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

  var escolacolor = {}; 

  var tamanhoescola = Object.keys(pontosfinal2).length;
  for (i = 0; i < tamanhoescola; i++) {
    var ponto = pontosfinal2[i]["endereco"].split(",");
    var escola = pontosfinal2[i]["escola"];
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
        infowindow.setContent(pontosfinal2[i]["completo"]);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }

  var tamanho = Object.keys(pontos2).length;
  for (i = 0; i < tamanho; i++) {
    var ponto = pontos2[i]["endereco"].split(",");
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





