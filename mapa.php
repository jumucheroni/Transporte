<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
  define('INFI',9999999999);
    include './inc/header.php';
    include './inc/conexao.php';

    $tipo = @$_POST["relatorio"];
    $periodo = @$_POST["periodo"];
    $veiculo = @$_POST["veiculo"];

    if ($periodo == 'm') {
      $periodo_conducao = " and ct.periodo_conducao in ('im')"; 
    } 
    if ($periodo == "a") {
      $periodo_conducao = " and ct.periodo_conducao in ('vm','it')"; 
    }
    if ($periodo == "t") {
      $periodo_conducao = " and ct.periodo_conducao in ('vt')"; 
    }
    if ($tipo == "E") {
        $valor = @$_POST['valor'];

        $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,  
        CONCAT(t.cep_origem,',',t.logradouro_origem,',',t.numero_origem,',',t.cidade_origem,',',t.estado_origem) as origem,
        CONCAT(t.cep_destino,',',t.logradouro_destino,',',t.numero_destino,',',t.cidade_destino,',',t.estado_destino) as destino from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho
        where ct.deletado ='N'".$periodo_conducao." and c.id_escola = ".$valor." and v.placa = '".$veiculo."'";
        $result = $conexao->query($sql);

        $sqlveiculo = "select cpf_ajudante from veiculo where placa = '".$veiculo."'";
        $resultveiculo = $conexao->query($sqlveiculo);
        $rowveiculo = @mysqli_fetch_array($resultveiculo);

        if ($rowveiculo['cpf_ajudante']) {
            $enderecos = array();

            $sqlajudante = "select CONCAT(cep,',',logradouro,',',numero,',',cidade,',',estado) as ajudante from ajudante where cpf = '".$rowveiculo['cpf_ajudante']."'";
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
        } else {
            $sqlcondutor = "select CONCAT(c.cep,',',c.logradouro,',',c.numero,',',c.cidade,',',c.estado) as condutor from condutor c INNER JOIN condveic cv ON cv.cpf_condutor = c.cpf where cv.placa = '".$veiculo."'".$periodo_condutor;
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
        }

        $cont = 0;
        
        $enderecos[$cont] = [
          'origem' => $LatLng_ajudante ? $LatLng_ajudante : $LatLng_ajudante,
          'destino' => ""
        ];

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

            $enderecos[$cont] = [
              'origem' => $LatLng_origem,
              'destino' => $LatLng_destino
            ];
            
            $cont++;
        }

        $enderecos[$cont] = [
            'origem' => "",
            'destino' => $LatLng_destino
        ];

        print_r($enderecos);

        $distancias = array();

        if ($periodo_conducao == 'im') {
          // calcular a distancia entre o ponto inicial e entre os pontos do caminho
          for ($i=0; $i < sizeof($enderecos);$i++){
            for ($j=0;$j < sizeof($enderecos)-1;$j++) {
              $LatLng_origem = explode(",", $enderecos[$i]["origem"]);
              if ($LatLng_origem[0])
                $Lat_origem = $LatLng_origem[0];
              if ($LatLng_origem[1])
               $Lng_origem = $LatLng_origem[1];
              $LatLng_destino = explode(",", $enderecos[$j]["origem"]);
              if ($LatLng_destino[0])
                $Lat_destino = $LatLng_destino[0];
              if ($LatLng_destino[1])
                $Lng_destino = $LatLng_destino[1];
              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($j == 0) {
                $d = INFI;
              }
              if ($i == (sizeof($enderecos) - 1)) {
                $d = INFI;
              }
              $distancias[$i][$j]['distancia'] = $d;
              $distancias[$i][$j]['origem'] = $enderecos[$i]["origem"];
              $distancias[$i][$j]['destino'] = $enderecos[$j]["origem"];
            }
          }
          // calcular a distancia entre os pontos do caminho e o destino
          for ($i = 0 ;$i < sizeof($enderecos);$i++){
              $LatLng_origem = explode(",", $enderecos[$i]["origem"]);
              if ($LatLng_origem[0])
                $Lat_origem = $LatLng_origem[0];
              if ($LatLng_origem[1])
                $Lng_origem = $LatLng_origem[1];
              $LatLng_destino = explode(",", $enderecos[$i]["destino"]);
              if ($LatLng_destino[0])
                $Lat_destino = $LatLng_destino[0];
              if ($LatLng_destino[1])
                $Lng_destino = $LatLng_destino[1];
              if ($Lat_origem && $Lng_origem && $Lat_destino && $Lng_destino)
                $d = sqrt(pow(($Lat_origem-$Lat_destino),2) + pow(($Lng_origem-$Lng_destino),2));
              if ($i == sizeof($enderecos)-1){
                $d = 0;
              }
              $distancias[$i][sizeof($enderecos)-1]["distancia"] = $d;
              $distancias[$i][sizeof($enderecos)-1]["origem"] = $enderecos[$i]["origem"];
              $distancias[$i][sizeof($enderecos)-1]["destino"] = $enderecos[$i]["destino"];
          }
        }

       $menor = array();
        for ($i=0; $i<  sizeof($enderecos)-1; $i++) {
            $menor[$i] = [
                'distancia' => 9999999999,
                'origem' => '',
                'destino' => ''
            ];

        }

        $n = sizeof($distancias);

        /*for($k=0; $k<$n; $k++)
          for($i=0; $i<$n; $i++)
            if( $i!=$k &&  $distancias[$i][$k] < INFI )
              for($j=0; $j<$n; $j++){
                $dist1 = $distancias[$i][$j];
                $dist2 = $distancias[$i][$k]+$distancias[$k][$j];
                print_r($dist1."---".$dist2);
                print_r("<BR><BR>");
                if( $distancias[$i][$j] > $distancias[$i][$k]+$distancias[$k][$j] ){
                  $distancias[$i][$j] = $distancias[$i][$k]+$distancias[$k][$j];
                }
              }*/

        //print_r($distancias);

        //print_r($distancias);
        /*for ($i=0; $i < sizeof($enderecos);$i++){
            for ($j=0;$j < sizeof($enderecos);$j++) {
                print_r("     ".$distancias[$i][$j]["distancia"]);
            }
            print_r("<br>");
          }*/

        $menor[0]['distancia'] = $distancias[0][1]["distancia"];
        $menor[0]['origem'] = $distancias[0][1]["origem"];
        $menor[0]['destino'] = $distancias[0][1]["destino"];

        $menor[1]['distancia'] = $distancias[1][2]["distancia"];
        $menor[1]['origem'] = $distancias[1][2]["origem"];
        $menor[1]['destino'] = $distancias[1][2]["destino"];

        $menor[2]['distancia'] = $distancias[2][3]["distancia"];
        $menor[2]['origem'] = $distancias[2][3]["origem"];
        $menor[2]['destino'] = $distancias[2][3]["destino"];

        $pontos[0] = $distancias[0][1]["origem"];
        $pontos[1] = $distancias[1][2]["origem"];
        $pontos[2] = $distancias[2][3]["origem"];
        $pontos[3] = $distancias[2][3]["destino"];

        $menor = json_encode($menor);
        $pontos = json_encode($pontos);
        // quando for ida pegar o endereco do ajudante / condutor ver a distancia dele para origem depois cada origem entre eles e a distancia para o destino
        // quando for volta pegar o endereco da escola ver a distancia para os destinos depois cada destido para a distancia entre eles e depois para a origem
        // matriz nxn das distâncias dos endereços 
        // depois incluir 
    }

?>        
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Itinerário</li>
              </ol>
            </div>
        <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
            <input type=hidden id="address" value='<?php echo $menor; ?>' />
            <input type="hidden" id="pontos" value='<?php echo $pontos; ?>'/>
            <h1 class="page-header">Mapa</h1>
				<div id="map" style="height: 500px"></div>
			</div>
		</div>

<?php include './inc/footer.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-2bniFa-QuG1YD6Il7TV3SLBYiqXrpQg&callback=initMap"
    async defer></script>
<script type="text/javascript">
/*	var map;
    function initMap() {
        var myLatLng = {lat: -22.331980, lng: -49.029568};
            var pointA = {lat: -22.331980, lng: -49.029568};
    var pointB = {lat: -22.333560, lng: -49.025712};
    var pointC = {lat: -22.330232, lng: -49.032303};

        myOptions = {
      zoom: 7,
      center: myLatLng
    }

  	map = new google.maps.Map(document.getElementById('map'), myOptions),
    
    directionsService = new google.maps.DirectionsService,
    directionsDisplay = new google.maps.DirectionsRenderer({
      map: map
    }),

  		markerA = new google.maps.Marker({
      		position: {lat: -22.331980, lng: -49.029568},
      		title: "point A",
      		label: "A",
      		map: map
    	});

    	markerB = new google.maps.Marker({
      		position: {lat: -22.333560, lng: -49.025712},
      		title: "point B",
      		label: "B",
      		map: map
    	});

    	markerC = new google.maps.Marker({
      		position: {lat: -22.330232, lng: -49.032303},
      		title: "point C",
      		label: "C",
      		map: map
    	});

  // get route from A to B
  calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);

} */

function initMap() {
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

var locations = $("#address").val();
locations = jQuery.parseJSON(locations);

var pontos = $("#pontos").val();
pontos = jQuery.parseJSON(pontos);

  directionsDisplay = new google.maps.DirectionsRenderer();


  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(-22.331980, -49.029568),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay.setMap(map);
  var infowindow = new google.maps.InfoWindow();

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };
  for (i = 0; i < pontos.length; i++) {
    var ponto = pontos[i].split(",");
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(ponto[0], ponto[1]),
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));

    if (i == 0) request.origin = marker.getPosition();
    else if (i == locations.length - 1) request.destination = marker.getPosition();
    else {
      if (!request.waypoints) request.waypoints = [];
      request.waypoints.push({
        location: marker.getPosition(),
        stopover: true
      });
    }

  }
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
}



function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
  directionsService.route({
    origin: pointA,
    destination: pointB,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });

  /*var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });*/
    }
</script>


<?php } ?>


