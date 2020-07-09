$(document).ready(function () {
   $('#btnCadastrarUsuario').on('click', function(){
      let email = $('#loginCadastro').val();
      let senha = $('#senhaCadastro').val();
      let nome = $('#nomeCadastro').val();
      let tipoUsuario = $('#selectTipoUsuario option:selected').val();
      var baseUrl = 'http://localhost:8000/api/usuario/criar';
      $.ajax({
          type: "POST",
          url: baseUrl,
          data: {'emailUsuario': email, 'senhaUsuario': senha, 'nomeUsuario':nome, 'codigoTipoUsuario': tipoUsuario},
          success: function (data) {
             console.log(data);
          }
      });
   });

   $('#btnEntrar').on('click', function(){
      let email = $('#loginText').val();
      let senha = $('#senhaText').val();
      var baseUrl = 'http://localhost:8000/api/login';
      $.ajax({
          type: "POST",
          url: baseUrl,
          data: {'email': email, 'senha': senha},
          success: function (data) {
             if(data.codigo === 200)
             {
                alert('LOGADOOOOOO');
             }
          }
      });
   });
})


