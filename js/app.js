$(document).ready(function(){
	//mascaras 
	$(".cpf").mask("999.999.999-99");
	$(".rg").mask("99999999-9");
	$(".money").maskMoney();
	$(".cep").mask("99999-999");
	$(".nasc").mask("99/99/9999");

	//preencher os estados e cidades
	$.getJSON('estados_cidades.json', function (data) {
		var items = [];
		var options = '<option value="">Selecione um estado</option>';	
		$.each(data, function (key, val) {
			options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
		});					
		$("#estado").html(options);				
		
		$("#estado").change(function () {				
		
			var options_cidades = '';
			var str = "";					
			
			$("#estado option:selected").each(function () {
				str += $(this).text();
			});
			
			$.each(data, function (key, val) {
				if(val.nome == str) {							
					$.each(val.cidades, function (key_city, val_city) {
						options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
					});							
				}
			});
			$("#cidade").html(options_cidades);
			
		}).change();		
	});

	//preencher os estados e cidades destinos trechos
	$.getJSON('estados_cidades.json', function (data) {
		var items = [];
		var options = '<option value="">Selecione um estado</option>';	
		$.each(data, function (key, val) {
			options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
		});					
		$("#estado_destino").html(options);				
		
		$("#estado_destino").change(function () {				
		
			var options_cidades = '';
			var str = "";					
			
			$("#estado_destino option:selected").each(function () {
				str += $(this).text();
			});
			
			$.each(data, function (key, val) {
				if(val.nome == str) {							
					$.each(val.cidades, function (key_city, val_city) {
						options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
					});							
				}
			});
			$("#cidade_destino").html(options_cidades);
			
		}).change();
	});		

	//preencher os estados e cidades origens trecho 
	$.getJSON('estados_cidades.json', function (data) {
		var items = [];
		var options = '<option value="">Selecione um estado</option>';	
		$.each(data, function (key, val) {
			options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
		});					
		$("#estado_origem").html(options);				
		
		$("#estado_origem").change(function () {				
		
			var options_cidades = '';
			var str = "";					
			
			$("#estado_origem option:selected").each(function () {
				str += $(this).text();
			});
			
			$.each(data, function (key, val) {
				if(val.nome == str) {							
					$.each(val.cidades, function (key_city, val_city) {
						options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
					});							
				}
			});
			$("#cidade_origem").html(options_cidades);
			
		}).change();		
	});

	function valCpf(strCPF){
		var Soma;
	    var Resto;
	    Soma = 0;
	    strCPF = strCPF.replace(/[^\d]+/g,'');
	  	if ((strCPF == "00000000000") || (strCPF == "11111111111") || (strCPF == "22222222222") || (strCPF == "33333333333") || (strCPF == "44444444444") || (strCPF == "55555555555") || (strCPF == "66666666666") || (strCPF == "77777777777") || (strCPF == "88888888888") || (strCPF == "99999999999") ){
	  		return false;
	  	}
	     
	  	for (i=1; i<=9; i++) {
	  		Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	  	}
	  	Resto = (Soma * 10) % 11;
	   
	    if ((Resto == 10) || (Resto == 11)) {
	    	Resto = 0;
	    } 

	    if (Resto != parseInt(strCPF.substring(9, 10)) ) {
	    	return false;
	    }
	   
	  	Soma = 0;
	    for (i = 1; i <= 10; i++) {
	    	Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
	    }
	    Resto = (Soma * 10) % 11;
	   
	    if ((Resto == 10) || (Resto == 11))  {
	    	Resto = 0;
	    }
	    if (Resto != parseInt(strCPF.substring(10, 11) ) ) {
	    	return false;
	    }
	    return true;
	}

	$("#ajudante-salvar").click(function(){
        if (valCpf($("#cpf").val())) {
            if ($("#acao").val()=="CADASTRAR"){
              	$("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
              	$("#acao").val("SALVARUPDATE");
            }
            $( "#ajudante" ).submit();
        } else {
            alert("CPF incorreto");
            $("#cpf").focus();
        }       
     });

    $("#condutor-salvar").click(function(){
     	if (valCpf($("#cpf").val())) {
          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#condutor" ).submit();
        } else {
            alert("CPF incorreto");
            $("#cpf").focus();
        }     
    });

    $("#responsavel-salvar").click(function(){
		if (valCpf($("#cpf").val())) {
          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#responsavel" ).submit();
        } else {
            alert("CPF incorreto");
            $("#cpf").focus();
        } 
    });

    // Limpa valores do formulário de cep.
    function limpa_formulário_cep() {
    	$("#cep").val("");
	    $("#logradouro").val("");
	    $("#bairro").val("");
	    $("#cidade").val("");
	    $("#estado").val("");
	    $("#cidade").html("");

        $("#cidade").attr("disabled",false);
		$("#estado").attr("disabled",false);
	}

	$("#cep").blur(function() {
	    var cep = $(this).val().replace(/\D/g, '');

	    if (cep != "") {
	        var validacep = /^[0-9]{8}$/;

	        if(validacep.test(cep)) {
	            $("#logradouro").val("...");
	            $("#bairro").val("...");
	            $("#cidade").val("...");
	            $("#estado").val("...");

	            //Consulta o webservice viacep.com.br/
	            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
	                if (!("erro" in dados)) {
	                    $.getJSON('estados_cidades.json', function (data) {
		
							var options_cidades = '';
							var str = "";					
							
							$("#estado option:selected").each(function () {
								str += $(this).text();
							});
							
							$.each(data, function (key, val) {
								if(val.nome == str) {							
									$.each(val.cidades, function (key_city, val_city) {
										if (val_city == dados.localidade){
											options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
										} else {
											options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
										}
									});							
								}
							});
							$("#cidade").html(options_cidades);
						});

						$("#logradouro").val(dados.logradouro);
	                    $("#bairro").val(dados.bairro);
	                    $("#cidade").val(dados.localidade);
	                    $("#estado").val(dados.uf);

	                    $("#cidade").attr("disabled",true);
	            		$("#estado").attr("disabled",true);
								
	                } 
	                else {
	                    limpa_formulário_cep();
	                    alert("CEP não encontrado.");
	                }
	            });
	        } 
	        else {
	            limpa_formulário_cep();
	            alert("Formato de CEP inválido.");
	        }
	    } 
	    else {
	        limpa_formulário_cep();
	    }
	});

	 // Limpa valores do formulário de cep.
    function limpa_formulário_cep_origem() {
    	$("#cep_origem").val("");
	    $("#logradouro_origem").val("");
	    $("#bairro_origem").val("");
	    $("#cidade_origem").val("");
	    $("#estado_origem").val("");
	    $("#cidade_origem").html("");

        $("#cidade_origem").attr("disabled",false);
		$("#estado_origem").attr("disabled",false);
	}

	$("#cep_origem").blur(function() {
	    var cep = $(this).val().replace(/\D/g, '');

	    if (cep != "") {
	        var validacep = /^[0-9]{8}$/;

	        if(validacep.test(cep)) {
	            $("#logradouro_origem").val("...");
	            $("#bairro_origem").val("...");
	            $("#cidad_origeme").val("...");
	            $("#estado_origem").val("...");

	            //Consulta o webservice viacep.com.br/
	            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
	                if (!("erro" in dados)) {
	                    $.getJSON('estados_cidades.json', function (data) {
		
							var options_cidades = '';
							var str = "";					
							
							$("#estado_origem option:selected").each(function () {
								str += $(this).text();
							});
							
							$.each(data, function (key, val) {
								if(val.nome == str) {							
									$.each(val.cidades, function (key_city, val_city) {
										if (val_city == dados.localidade){
											options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
										} else {
											options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
										}
									});							
								}
							});
							$("#cidade_origem").html(options_cidades);
						});

						$("#logradouro_origem").val(dados.logradouro);
	                    $("#bairro_origem").val(dados.bairro);
	                    $("#cidade_origem").val(dados.localidade);
	                    $("#estado_origem").val(dados.uf);

	                    $("#cidade_origem").attr("disabled",true);
	            		$("#estado_origem").attr("disabled",true);
								
	                } 
	                else {
	                    limpa_formulário_cep_origem();
	                    alert("CEP não encontrado.");
	                }
	            });
	        } 
	        else {
	            limpa_formulário_cep_origem();
	            alert("Formato de CEP inválido.");
	        }
	    } 
	    else {
	        limpa_formulário_cep_origem();
	    }
	});

	// Limpa valores do formulário de cep.
    function limpa_formulário_cep_destino() {
    	$("#cep_destino").val("");
	    $("#logradouro_destino").val("");
	    $("#bairro_destino").val("");
	    $("#cidade_destino").val("");
	    $("#estado_destino").val("");
	    $("#cidade_destino").html("");

        $("#cidade_destino").attr("disabled",false);
		$("#estado_destino").attr("disabled",false);
	}

	$("#cep_destino").blur(function() {
	    var cep = $(this).val().replace(/\D/g, '');

	    if (cep != "") {
	        var validacep = /^[0-9]{8}$/;

	        if(validacep.test(cep)) {
	            $("#logradouro_destino").val("...");
	            $("#bairro_destino").val("...");
	            $("#cidad_destinoe").val("...");
	            $("#estado_destino").val("...");

	            //Consulta o webservice viacep.com.br/
	            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
	                if (!("erro" in dados)) {
	                    $.getJSON('estados_cidades.json', function (data) {
		
							var options_cidades = '';
							var str = "";					
							
							$("#estado_destino option:selected").each(function () {
								str += $(this).text();
							});
							
							$.each(data, function (key, val) {
								if(val.nome == str) {							
									$.each(val.cidades, function (key_city, val_city) {
										if (val_city == dados.localidade){
											options_cidades += '<option selected="true" value="' + val_city + '">' + val_city + '</option>';
										} else {
											options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
										}
									});							
								}
							});
							$("#cidade_destino").html(options_cidades);
						});

						$("#logradouro_destino").val(dados.logradouro);
	                    $("#bairro_destino").val(dados.bairro);
	                    $("#cidade_destino").val(dados.localidade);
	                    $("#estado_destino").val(dados.uf);

	                    $("#cidade_destino").attr("disabled",true);
	            		$("#estado_destino").attr("disabled",true);
								
	                } 
	                else {
	                    limpa_formulário_cep_destino();
	                    alert("CEP não encontrado.");
	                }
	            });
	        } 
	        else {
	            limpa_formulário_cep_destino();
	            alert("Formato de CEP inválido.");
	        }
	    } 
	    else {
	        limpa_formulário_cep_destino();
	    }
	});



});