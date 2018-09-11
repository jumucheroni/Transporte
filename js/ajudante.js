$(document).ready(function(){
	$("#ajudante-salvar").click(function(){
        if ((valCpf($("#cpf").val())) && ($("#nome").val() != "") && ($("#salario").val() != "") && ($("#cep").val() != "") && ($("#logradouro").val() != "") && ($("#numero").val() != "") && ($("#bairro").val() != "") && ($("#estado").val() != "") && ($("#cidade").val() != ""))  {
            if ($("#acao").val()=="CADASTRAR"){
              	$("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
              	$("#acao").val("SALVARUPDATE");
            }
	        $("#cidade").attr("disabled",false);
	        $("#estado").attr("disabled",false);
            $( "#ajudante" ).submit();
        } else {
        	var erro = 0;
        	if (!(valCpf($("#cpf").val()))) {
	           //colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#nome").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#salario").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#cep").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#logradouro").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#numero").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#bairro").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#estado").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (!($("#cidade").val() != "")) {
        		//colocar a borda vermelha no campo
	           erro = 1;
        	}
        	if (erro) {
        		alert("Existem campos obrigatorios preenchidos incorretamente");
        	}
        }       
    });
});