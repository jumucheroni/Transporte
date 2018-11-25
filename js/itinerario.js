$(document).ready(function(){
	$("#gerar").click(function(){
		$("#modal").show();
	});
	 $('input[type=radio][name=relatorio]').change(function() {
          if (this.value == 'T') {
              $("#escolas").hide();
          }
          if (this.value == 'E') {
              $("#escolas").show();
          }
      });

	if ($('input[type=radio][name=relatorio]').val() == 'E'){
		$("#escolas").show();
	}

	 var roteiro = {};
	 var nroteiro = {};
	 var roteirizado = [];
	 var pontos = [];
	 var escolasnoroteiro = [];
	 var lotacao = 0;
	 var criancaescola = {};
	 var criancaescolail = {};
	 var criancaescolavl = {};

	 if ($("#criancaescolav").val()) {
	 	var criancaescolav = jQuery.parseJSON($("#criancaescolav").val());
	 	var tam = Object.keys(criancaescolav).length;
		for (var i = 0; i < tam; i++) {
			if (!criancaescola[criancaescolav[i]['escola']]) {
				criancaescola[criancaescolav[i]['escola']] = 1;
			}  else {
				criancaescola[criancaescolav[i]['escola']] += 1;
			}
			if (!criancaescolavl[criancaescolav[i]['escola']]) {
				criancaescolavl[criancaescolav[i]['escola']] = 1;
			}  else {
				criancaescolavl[criancaescolav[i]['escola']] += 1;
			}
		}
	 }

	 if ($("#criancaescolai").val()) {
	 	var criancaescolai = jQuery.parseJSON($("#criancaescolai").val());
	 }

	 comboelement = document.getElementById('combo');
	 if (comboelement) {
		 for (i = 0; i< comboelement.length; i++) {
		 	c = comboelement.options[i].value.split("_");
		 	nroteiro[c[0]] = comboelement.options[i].text;
		 }
	}

	 $("#adicionar").click(function(){
	 	var select = $("#combo option:selected").val();
	 	var escola = 0;
	 	var selecionado = 0;
	 	if (select.indexOf('_') > -1) {
	 		select = select.split("_");
	 		selecionado = select[0];
	 		escola = select[1];
	 		if (escola) {
	 			escolasnoroteiro[roteirizado.length] = escola;
	 		}
	 	} else {
	 		selecionado = select;
	 	}
	 	var lotveiculo = $("#lotacao").val();
	 	var periodo = $("#periodo").val();
	 	if ((periodo == 't' && escola == 0) || (periodo == 'a' && select[3]=='vm')) {
	 		hasescola = false;
		 	for (i = 0; i< escolasnoroteiro.length; i++){
		 		if (escolasnoroteiro[i] == select[2]){
		 			hasescola = true;
		 		}
		 	}
		 	if (!hasescola) {
		 		alert('Esta criança ainda não foi pega na escola');
			 	return false;
		 	}
		}
		if (periodo == 'a' && escola > 0) {
			var tami = Object.keys(criancaescolai).length;
			var tamv = Object.keys(criancaescolav).length;
			var indo = false;
			var voltando = false;
			for (i = 0;i < tami; i++) {
				if (criancaescolai[i]['escola'] == escola) {
					indo = true;
				}
			}
			for (j = 0;j < tamv; j++) {
				if (criancaescolav[j]['escola'] == escola) {
					voltando = true;
				}
			}

			if (indo && voltando) {
				if ((criancaescolail[escola] == 0 || !criancaescolail[escola]) && (criancaescolavl[escola] - criancaescolail[escola] + lotacao > lotveiculo)) { 
		 			alert('Não há crianças para serem deixadas nessa escola');
		 			return false;
		 		}
			} else  {
				if (indo) {
					if ((criancaescolail[escola] == 0 || !criancaescolail[escola])) { 
			 			alert('Não há crianças para serem deixadas nessa escola');
			 			return false;
			 		}
				}
				if (voltando) {
					if ((criancaescolavl[escola] + lotacao > lotveiculo)) {
			 			alert('Não é possível pegar as criancas dessa escola, pois ultrapassa o limite do transporte');
			 			return false;
		 			}
				}
			}
		}
	 	if (lotacao < lotveiculo || escola > 0) {
		 	if ((nroteiro[selecionado])) {
		 		if (periodo == 'm' && (criancaescola[escola] == 0 || !criancaescola[escola]) && escola > 0) { 
		 			alert('Não há crianças para serem deixadas nessa escola');
		 			return false;
		 		}
		 		if (periodo == 't' && (criancaescola[escola] + lotacao > lotveiculo)) {
		 			alert('Não é possível pegar as criancas dessa escola, pois ultrapassa o limite do transporte');
		 			return false;
		 		}
		 		if (periodo == 't' ){

		 		}
		 		$("#roteiro").append("<p id=end"+selecionado+">"+nroteiro[selecionado]+"</p>");
		 		roteiro[selecionado] = nroteiro[selecionado];
		 		nroteiro[selecionado] = "";
		 		roteirizado.push(roteiro[selecionado]);
		 		escolas = $("#enderecosescolas").val();
		 		if (escolas) {
		 			escolas = jQuery.parseJSON(escolas);
		 		}
		 		escolas2 = $("#enderecos2escolas").val();
		 		if (escolas2) {
		 			escolas2 = jQuery.parseJSON(escolas2);
		 		}
		 		periodo = $("#periodo").val(); 
		 		$.ajax({
	                    url: "geo.php",
	                    type: "post",
	                    dataType: "json",
	                    data: {
	                    	'roteiro':roteirizado[roteirizado.length-1]
	                    },
	                    success: function(result){
	                    	if (result) {
	                       		pontos[roteirizado.length-1] = result;
	                       		if (periodo == 'm') {
		                       		if (escola == 0) {
		                       			lotacao++; 
		                       			if (!criancaescola[select[2]]) {
		                       				criancaescola[select[2]] = 1;
		                       			} else { 
											criancaescola[select[2]] += 1;
		                       			}
		                       		} else {
		                       			lotacao -= criancaescola[escola]; 
		                       			criancaescola[escola] = 0;
		                       		}
		                       	}
		                       	if (periodo == 'a') {
		                       		if (escola == 0) {
		                       			if (select[3]=='vm') {
			                       			lotacao--; 
											criancaescolavl[select[2]] -= 1;
										} 
										if (select[3]=='0') {
											lotacao++;
										}
										if (select[3] == 'it') {
											lotacao++; 
			                       			if (!criancaescolail[select[2]]) {
			                       				criancaescolail[select[2]] = 1;
			                       			} else { 
												criancaescolail[select[2]] += 1;
			                       			}
										}
		                       		} else {
		                       			if (indo && voltando) {
											lotacao -= criancaescolail[escola]; 
		                       				criancaescolail[escola] = 0;
		                       				lotacao += criancaescolavl[escola];
										} else  {
											if (indo) {
												lotacao -= criancaescolail[escola]; 
		                       					criancaescolail[escola] = 0;
											}
											if (voltando) {
												lotacao += criancaescolavl[escola]; 
											}
										}
		                       		}
		                       	}
		                       	if (periodo == 't') {
		                       		if (escola == 0) {
		                       			if (select[2] == 0){
		                       				lotacao++;
		                       			} else {
			                       			lotacao--; 
											criancaescola[select[2]] -= 1;
										}
		                       		} else {
		                       			lotacao += criancaescola[escola]; 
		                       		}
		                       	}
	                       	}
					 		if (roteirizado.length > 1) {
					 			maparoteiro(roteirizado,pontos,escolas,escolas2,periodo,escolasnoroteiro);
					 		}
	                    }
	                });
		 	} else {
		 		alert("Ponto já incluído");
		 	}
		 } else {
		 	alert("Lotação do veículo atingida");
		 }
	 });
	 $("#remover").click(function(){
	 	roteiro = {};
	    nroteiro = {};
	    roteirizado = [];
	    pontos = [];
	    escolasnoroteiro = [];
	    lotacao = 0;
	    criancaescola = {};
	    criancaescolail = {};
	    criancaescolavl = {};

		 comboelement = document.getElementById('combo');
		 if (comboelement) {
			 for (i = 0; i< comboelement.length; i++) {
			 	c = comboelement.options[i].value.split("_");
			 	nroteiro[c[0]] = comboelement.options[i].text;
			 }
		}

		if ($("#criancaescolav").val()) {
		 	var criancaescolav = jQuery.parseJSON($("#criancaescolav").val());
		 	var tam = Object.keys(criancaescolav).length;
			for (var i = 0; i < tam; i++) {
				if (!criancaescola[criancaescolav[i]['escola']]) {
					criancaescola[criancaescolav[i]['escola']] = 1;
				}  else {
					criancaescola[criancaescolav[i]['escola']] += 1;
				}
			}
		 }

		if ($("#criancaescolai").val()) {
		 	var criancaescolai = jQuery.parseJSON($("#criancaescolai").val());
		}

	 	$("#roteiro").html("");
	 	$("#pdf").hide();
	 });



	 function maparoteiro(roteiro,pontoslatlong,escolas = null, escolas2 = null, periodo = null, escolasnoroteiro = null) {
	 	$("#pdf").show();
	 	var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var pinColor = ['000080','FFFF00','00CED1','CD5C5C','006400','2E8B57']
		var labelIndex = 0;
		var map;
		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var infowindow = new google.maps.InfoWindow();

		var pontos = roteiro;
		
		  directionsDisplay = new google.maps.DirectionsRenderer({
		    polylineOptions: {
		      strokeColor: "blue"
		    }, suppressMarkers: true
		  });
		if (pontos.length){
		  var map = new google.maps.Map(document.getElementById('maproteiros'), {
		    zoom: 10,
		    center: new google.maps.LatLng(-22.331980, -49.029568),
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  });
		  directionsDisplay.setMap(map);

		  var marker, i;
		  var request = {
		    travelMode: google.maps.TravelMode.DRIVING
		  };

		  var tamanho = Object.keys(pontos).length;
		  for (var i = 0; i < tamanho; i++) {
			marker = new google.maps.Marker({
		      position: new google.maps.LatLng(pontoslatlong[i][0]["lat"], pontoslatlong[i][0]["long"]),
		      label: labels[labelIndex++ % labels.length],
	  		  map: map
		    });

		    google.maps.event.addListener(marker, 'click', (function(marker, i) {
		      return function() {
		        infowindow.setContent(pontos[i]);
		        infowindow.open(map, marker);
		      }
		    })(marker, i));

		    if (i == 0) {
		      request.origin = marker.getPosition();
		    } else {
		      if (i == tamanho-1) {
		        request.destination = marker.getPosition();
		      } else {
		        if (!request.waypoints) request.waypoints = [];
		        request.waypoints.push({
		          location: marker.getPosition(),
		          stopover: true
		        });
		      }
		    }  
		  }
		  directionsService.route(request, function(result, status) {
		    if (status == google.maps.DirectionsStatus.OK) {
		      directionsDisplay.setDirections(result);
		      var panel = document.getElementById("panel");
		      panel.innerHTML = ""; 
		      var rotas = result.routes[0].legs.length;
		      var tempototal = 0;
		      var distanciatotal = 0;
		      var j = labelIndex-rotas-1;
		      var hIni,hIni2,timetotal,timetotal2;

		      var  tabela = document.createElement("table");
			  var  cabecalho = document.createElement("thead");
			  var  corpo = document.createElement("tbody");

			  tabela.className = "table table-responsive";
		      tabela.style.cssText = "background-color: #eff5f5";

		      tabela.appendChild(cabecalho);
		      tabela.appendChild(corpo);

		      var th = document.createElement("th");
		      var texto = document.createTextNode("Origem");
		      th.appendChild(texto);
		      cabecalho.appendChild(th);
		      var th = document.createElement("th");
		      texto = document.createTextNode("Destino");
		      th.appendChild(texto);
		      cabecalho.appendChild(th);
		      var th = document.createElement("th");
		      texto = document.createTextNode("Distância");
		      th.appendChild(texto);
		      cabecalho.appendChild(th);
		      var th = document.createElement("th");
		      texto = document.createTextNode("Tempo");
		      th.appendChild(texto);
		      cabecalho.appendChild(th);

		      for (i=0;i<rotas;i++) {
		        var tr = document.createElement("tr");
		        var td = document.createElement("td");
		        var texto = document.createTextNode(result.routes[0].legs[i].start_address);
		        td.appendChild(texto);
		        tr.appendChild(td);
		        var td = document.createElement("td");
		        var texto = document.createTextNode(result.routes[0].legs[i].end_address);
		        td.appendChild(texto);
		        tr.appendChild(td);
		        var td = document.createElement("td");
		        var texto = document.createTextNode(result.routes[0].legs[i].distance.text);
		        td.appendChild(texto);
		        tr.appendChild(td);
		        var td = document.createElement("td");
		        var texto = document.createTextNode(result.routes[0].legs[i].duration.text);
		        td.appendChild(texto);
		        tr.appendChild(td);
		        corpo.appendChild(tr);

		        tempototal += result.routes[0].legs[i].duration.value;
		        distanciatotal += result.routes[0].legs[i].distance.value;

		        if (escolasnoroteiro[i+1] > 0) {
		        	if (periodo == 'm' || periodo == 'a') {
				        if (periodo == 'm') {
				          for (p = 0; p < escolas.length; p++) {
				          	if (escolas[p]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni = escolas[p]['horario'][0].split(':'); 
				          		esc = escolas[p]['completo'].split(" - ");
				          	}
				          }
				        }
				        if (periodo == 'a') {
				          for (p = 0; p < escolas.length; p++) {
				          	if (escolas[p]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni = escolas[p]['horario'][2].split(':'); 
				          		esc = escolas[p]['completo'].split(" - ");
				          	}
				          }
				          for (q = 0; q < escolas.length; q++) {
				          	if (escolas[q]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni2 = escolas[q]['horario'][1].split(':'); 
				          		esc2 = escolas[q]['completo'].split(" - ");
				          	}
				          }
				        }
				        if (hIni) {
					        minutosTotal = parseInt(hIni[1], 10) - parseInt(tempototal / 60); 
					        horasTotal = parseInt(hIni[0], 10); 
					        if(minutosTotal < 0)
					        { 
					          minutosTotal += 60; 
					          horasTotal -= 1; 
					        }
					        if (minutosTotal < 10) {
					          minutosTotal = "0"+minutosTotal;
					        }
					        if (horasTotal < 10) {
					          horasTotal = "0"+horasTotal;
					        }
					        timetotal = horasTotal+":"+minutosTotal;
					    }
				        if (hIni2) {
				        	minutosTotal2 = parseInt(hIni2[1], 10) - parseInt(tempototal / 60); 
					        horasTotal2 = parseInt(hIni2[0], 10); 
					        if(minutosTotal2 < 0)
					        { 
					          minutosTotal2 += 60; 
					          horasTotal2 -= 1; 
					        }
					        if (minutosTotal2 < 10) {
					          minutosTotal2 = "0"+minutosTotal2;
					        }
					        if (horasTotal2 < 10) {
					          horasTotal2 = "0"+horasTotal2;
					        }
					        timetotal2 = horasTotal2+":"+minutosTotal2;
					    }
				        if (timetotal) {
				        	panel.innerHTML += "<p> Para chegar na escola "+esc[0]+" no horário da entrada o condutor deve sair no máximo: "+timetotal+ " </p>" ;
		        		} 
		        		if (timetotal2) {
		        			panel.innerHTML += "<p> Para chegar na escola "+esc2[0]+" no horário da saída o condutor deve sair no máximo: "+timetotal2+ " </p>" ;
		        		}
		        	}
		        	if (periodo == 't') {
				        for (p = 0; p < escolas.length; p++) {
				          	if (escolas[p]['escola'] == escolasnoroteiro[i+1]) {
				          		hIni = escolas[p]['horario'][3].split(':'); 
				          		esc = escolas[p]['completo'].split(" - ");
				          	}
				        }
				        minutosTotal = parseInt(hIni[1], 10) - parseInt(tempototal / 60); 
				        horasTotal = parseInt(hIni[0], 10); 
				        if(minutosTotal < 0)
				        { 
				          minutosTotal += 60; 
				          horasTotal -= 1; 
				        }
				        if (minutosTotal < 10) {
				          minutosTotal = "0"+minutosTotal;
				        }
				        if (horasTotal < 10) {
				          horasTotal = "0"+horasTotal;
				        }
				        timetotal = horasTotal+":"+minutosTotal;
				        panel.innerHTML += "<p> Para chegar na escola "+esc[0]+" no horário da saída o condutor deve sair no máximo: "+timetotal+ " </p>" ;
		        	}
		      	}
		      }
		      distanciatotal = distanciatotal / 1000;
		      distanciatotal = distanciatotal.toFixed(1);

		      tempototal = tempototal / 60;
		      tempototal = tempototal.toFixed(0);

		      var tr = document.createElement("tr");
		      var td = document.createElement("td");
		      var texto = document.createTextNode("Total");
		      td.appendChild(texto);
		      tr.appendChild(td);
		      var td = document.createElement("td");
		      var texto = document.createTextNode("");
		      td.appendChild(texto);
		      tr.appendChild(td);
		      var td = document.createElement("td");
		      var texto = document.createTextNode(distanciatotal+" km");
		      td.appendChild(texto);
		      tr.appendChild(td);
		      var td = document.createElement("td");
		      var texto = document.createTextNode(tempototal+" min");
		      td.appendChild(texto);
		      tr.appendChild(td);
		      corpo.appendChild(tr);
		      panel.appendChild(tabela);
      		}
		  });
		}
	 }

	function export_to_pdf() {
		var	roteiro = $("#panel").html();
		var img = $("#show_img").html();
		var condutor = $("#condutor").val();
		var ajudante = $("#ajudante").val();
		var assunto = $("#assunto").val();
		var corpo = $("#corpo").val();
		$.ajax({
            url: "downloadpdf.php",
            type: "post",
            data: {
            	'html': roteiro,
            	'img': img,
            	'condutor': condutor,
            	'ajudante': ajudante,
            	'assunto': assunto,
            	'corpo':corpo
            },
            success: function(result){
            	window.open("http://localhost/Transporte/"+result,'_blank');
            }
        });
	}

	$("#epdf").click(function() { 
        html2canvas($("#maproteiros"), {
	        useCORS: true,
	        onrendered: function (canvas) {
					
		        var img = canvas.toDataURL("image/png");

	          $('#img_val').val(canvas.toDataURL("image/png"));
	          $('#show_img').html("");
		        $("#show_img").append('<img src="' + img + '"/>');
		        $("#show_img").hide();
		       export_to_pdf();
	        }
	    });
    });

    $("#epdf_otimizado").click(function() { 
        html2canvas($("#maps"), {
	        useCORS: true,
	        onrendered: function (canvas) {
					
		        var img = canvas.toDataURL("image/png");

	          $('#img_val').val(canvas.toDataURL("image/png"));
	          $('#show_img').html("");
		        $("#show_img").append('<img src="' + img + '"/>');
		        $("#show_img").hide();
		        export_to_pdf();
	        }
	    });
    });
});
