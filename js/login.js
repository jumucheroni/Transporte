$(document).ready(function(){
	$("#entrar").click(function(){
		var dados = $("#login").serialize();
		$.ajax({
			url: "entrar_login.php",
			type: "post",
			dataType: "json",
			data: dados,
			success: function(result){
				switch (result.erro) {
					case 0: {
						$("#alert").html('<div class="alert bg-success" role="alert"> Login Efetuado com sucesso. Você será redirecionado <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
						window.location = result.url;
						$("#alert").show();
						break;
					}
					case 1: {
						$("#alert").html('<div class="alert bg-warning" role="alert"> Você já está logado. Você será redirecionado <a id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
						window.location = result.url;
						$("#alert").show();
						break;
					}
					case 2: {
						$("#alert").html('<div class="alert bg-danger" role="alert"> Usuario ou senha inválida <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
						$("#alert").show();
						break;
					}
					case 3: {
						$("#alert").html('<div class="alert bg-danger" role="alert"> Campos preenchidos incorretamente <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
						$("#alert").show();
						break;
					}
				}
    		}
		});
		return false;
	});

	$("#close-alert").on('click' , function(){
		console.log("TESTE");
		$("#alert").hide();
	});
	
	$("#cadastrar").click(function(){
		$("#cadastro").show();
		$("#logar").hide();
	});

	$("#voltar").click(function(){
		$("#cadastro").hide();
		$("#logar").show();
	});

	$("#salvar").click(function(){
		var dados = $("#form-cadastro").serialize();
		$.ajax({
			url: "cadastro_login.php",
			type: "post",
			dataType: "json",
			data: dados,
			success: function(result){
				switch (result.erro) {
					case 0: {
						alert("Cadastro realizado com sucesso. Você será redirecionado");
						window.location = result.url;
						break;
					}
					case 1: {
						alert("Você já está logado. Você será redirecionado");
						window.location = result.url;
						break;
					}
					case 2: {
						alert("Erro ao efetuar cadastro");
						$("#logar").show();
						$("#cadastro").hide();
						break;
					}
				}
    		}
		});
		return false;
	});	
});