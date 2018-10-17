$(document).ready(function(){
	$("#gerar-recibo").click(function(){
        if (($("#crianca").val() != "") && ($("#mes").val() != ""))  {
          	$("#acao").val("GERARRECIBO");
            var dados = $("#recibo").serialize();
            $("#recibo").submit();
            $("#modal").show();
            /*$.ajax({
                url: "mostra_recibo.php",
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
                        window.location="recibo.php";
                    },2000);
                }
            });*/
        } else {
        	var erro = 0;
        	if (!($("#crianca").val() != "")) {
        		$("#crianca-form").addClass("has-error");
	           erro = 1;
        	} else {
                $("#crianca-form").removeClass("has-error");
            }
            if (!($("#mes").val() != "")) {
                $("#mes-form").addClass("has-error");
               erro = 1;
            } else {
                $("#mes-form").removeClass("has-error");
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

    $("#print").click(function(){
        window.print();
    });
});