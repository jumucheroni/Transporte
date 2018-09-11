$(document).ready(function(){
  $("#crianca-salvar").click(function(){
        if (($("#nome").val() != "") && ($("#cpf_responsavel").val() != "") && ($("#n_ident_escola").val() != "") && ($("#data_nascimento").val() != "")) {
            if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
            }    
            if ($("#acao").val()=="ALTERAR"){
                $("#acao").val("SALVARUPDATE");
            }
          $( "#crianca" ).submit();
        } else {
          var erro = 0;
          if (!($("#nome").val() != "")) {
                //colocar a borda vermelha no campo
               erro = 1;
          }
          if (!($("#cpf_responsavel").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#n_ident_escola").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (!($("#data_nascimento").val() != "")) {
            //colocar a borda vermelha no campo
             erro = 1;
          }
          if (erro) {
            alert("Existem campos obrigatorios preenchidos incorretamente");
          }
        }       
    });
});