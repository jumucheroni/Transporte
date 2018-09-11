$(document).ready(function(){
  $("#despesa-salvar").click(function(){
        if (($("#placa_veiculo").val() != "") && ($("#data_gasto").val() != "") && ($("#valor_gasto").val() != "") && ($("#tipo").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
            }
          $( "#despesa" ).submit();
        } else {
          var erro = 0;
          if (!($("#placa_veiculo").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
          }
          if (!($("#data_gasto").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#valor_gasto").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#tipo").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Existem campos obrigatorios preenchidos incorretamente");
          }
        }       
    });
});