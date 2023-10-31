async function dadosUsuarioPreview(pk_usuario){
    const response = await fetch(import.meta.env.VITE_ROOT_API+'buscaDadosUsuario.php?dadosPreview=1', {
        method: 'POST',
        body: JSON.stringify({
            pk_usuario: pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

        return false

      }else{
        const dados = await response.json()
        setDadosUsuarioLocal(dados)
        
        return true

      }
}
function setDadosUsuarioLocal(dados){
    localStorage.setItem('dadosUsuario', JSON.stringify(dados))
            
}
async function getDadosUsuarioLocal(){
    if((localStorage.getItem('dadosUsuario')) == null){
      
      return null

    }else{
      let usuarioString = localStorage.getItem('dadosUsuario')
      let usuarioObj = JSON.parse(usuarioString)
      let pk_usuarioTemp = usuarioObj[0].pk_usuario
      await dadosUsuarioPreview(pk_usuarioTemp)
      usuarioString = localStorage.getItem('dadosUsuario')
      usuarioObj = JSON.parse(usuarioString)
      
      return usuarioObj

    }
}
async function deleteDadosUsuario(){
    localStorage.removeItem('dadosUsuario')

}
async function geradorSenha(){
  var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLMNOPQRSTUVWXYZ!@#$%^&*()+?><:{}[]"
  var passwordLength = 8;
  var password = ""

  for(var i = 0; i < passwordLength; i++){
    var randomNumber = Math.floor(Math.random()*chars.length)
    password += chars.substring(randomNumber, randomNumber + 1)

  }
  return password

}

export {getDadosUsuarioLocal,
        dadosUsuarioPreview,
        deleteDadosUsuario,
        geradorSenha}