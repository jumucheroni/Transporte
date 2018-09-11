$(document).ready(function(){
  $("#veiculo-salvar").click(function(){
        if (($("#placa").val() != "") && ($("#lotacao").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
            }
          $("#cidade").attr("disabled",false);
          $("#estado").attr("disabled",false);
          $( "#veiculo" ).submit();
        } else {
          var erro = 0;
          if (!($("#placa").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
          }
          if (!($("#lotacao").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Existem campos obrigatorios preenchidos incorretamente");
          }
        }       
    });
});