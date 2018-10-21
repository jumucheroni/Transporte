$(document).ready(function(){
	$("#recebimento-salvar").click(function(){
        if (($("#data_pgto").val() != "") && ($("#valor_pago").val() != ""))  {
            if ($("#acao").val()=="PAGAR"){
              	$("#acao").val("SALVARPAGAMENTO");
                var dados = $("#recebimentos").serialize();
                $("#modal").show();
                $.ajax({
                    url: "salvar_recebimentos.php",
                    type: "post",
                    dataType: "json",
                    data: dados,
                    success: function(result){
                        $("#modal").hide();
                        if (result.success){
                            $("#alert").html('<div class="alert bg-success" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                        } else {
                            $("#alert").html('<div class="alert bg-danger" role="alert">'+result.mensagem+'<a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');  
                        }
                        $("#alert").show();
                        setTimeout(function(){
                            $("#alert").hide();
                            window.location="visu_recebimentos.php";
                        },2000);
                    }
                });
            }
        } else {
        	var erro = 0;
        	if (!($("#data_pgto").val() != "")) {
        		$("#data_pgto-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#data_pgto-form").removeClass("has-error");
            }
        	if (!($("#valor_pago").val() != "")) {
        		$("#valor_pago-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#valor_pago-form").removeClass("has-error");
            }
        	if (erro) {
                $("#alert").html('<div class="alert bg-danger" role="alert"> Existem campos obrigatorios preenchidos incorretamente <a type="button" id="close-alert" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
                $("#alert").show();
                setTimeout(function(){
                    $("#alert").hide();
                },2000);
        	}
        }       
    });
});