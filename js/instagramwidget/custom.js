function getUserInstagramGraph(e) {
  e.disabled = true;
  let token = document.getElementById("instagramwidget_general_token").value;
  let iduser = document.getElementById("instagramwidget_general_iduser");
  let username = document.getElementById("instagramwidget_general_username");

  if(token.length > 1){
    let settings = {
      "async": true,
      "crossDomain": true,
      "url": `https://graph.instagram.com/v12.0/me?fields=id,username&access_token=${token}`,
      "method": "GET",
      "headers": {
        "Content-Type": "application/json",
        "Accept": "*/*",
      }
    }
    
    jQuery.ajax(settings).error(function(resp){
      var html = '<ul class="messages"><li class="warning-msg"><ul><li>Valide se o token está correto.</li></ul></li></ul>';
      $('messages').update(html);
      e.disabled = false;
    }).success(function(resp){
      if(resp.id){
        iduser.value = `${resp.id}`
        username.value = `${resp.username}`
        var html = `<ul class="messages"><li class="success-msg"><ul><li>Dados atualizado com sucesso!<br>
        Atenção: Salve a pagina antes de sair.</li></ul></li></ul>`;
        $('messages').update(html);
        e.disabled = false;
      }
    }).done(function () {
      e.disabled = false;
    });

  }else{
    var html = '<ul class="messages"><li class="error-msg"><ul><li>Por favor, insira um token</li></ul></li></ul>';
    $('messages').update(html);
    e.disabled = false;
  }
  
   
}

function getMediaInstagramGraph(url) {

  
  let submit = document.querySelector("#row_instagramwidget_conversion_run .value button");
  old_html_btn = submit.innerHTML;
  submit.disabled = true;
  submit.innerHTML = '<span><span><span>Aguarde <i class="fa fa-spinner fa-spin"></i></span></span></span>'
 
  let settings = {
    "async": true,
    "crossDomain": true,
    "url": `${url}`,
    "method": "GET",
    "headers": {
      "Content-Type": "application/json",
      "Accept": "*/*",
    }
  }

  jQuery.ajax(settings).done(function (resp) {
    var results = JSON.parse(resp);
      var html = '<ul class="messages"><li class="'+results.type+'-msg"><ul><li>' + results.message + '</li></ul></li></ul>';
      $('messages').update(html);
      submit.innerHTML = old_html_btn
  });

  submit.disabled = false;

}
