$(document).ready(function(){
  $("#condveic-salvar").click(function(){
        if (($("#veiculo").val() != "") && ($("#condutor").val() != "") && ($("#periodo").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
            }
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
            }
          $( "#condveic" ).submit();
        } else {
          var erro = 0;
          if (!($("#veiculo").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
          }
          if (!($("#condutor").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#periodo").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Existem campos obrigatorios preenchidos incorretamente");
          }
        }       
    });
});