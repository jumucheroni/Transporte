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
						alert("Login Efetuado com sucesso. Você será redirecionado");
						window.location = result.url;
						break;
					}
					case 1: {
						alert("Você já está logado. Você será redirecionado");
						window.location = result.url;
						break;
					}
					case 2: {
						alert("Usuario ou senha inválida");
						break;
					}
					case 3: {
						alert("Campos preenchidos incorretamente");
						break;
					}
				}
    		}
		});
		return false;
	});
	$("#cadastrar").click(function(){
		$("#cadastro").show();
		$("#logar").hide();
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