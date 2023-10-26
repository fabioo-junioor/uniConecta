async function dadosUsuarioPreview(pk_usuario){
    const response = await fetch(import.meta.env.VITE_ROOT_API+'buscaDadosUsuario.php?dadosPreview=1', {
        method: 'POST',
        body: JSON.stringify({
            pk_usuario: pk_usuario
        })
      })
      if(!response.ok){
        console.log(response.status)

      }else{
        const dados = await response.json()
        //console.log("salvo--> ", dados)
        setDadosUsuarioLocal(dados)

      }
}
function setDadosUsuarioLocal(dados){
    localStorage.setItem('dadosUsuario', JSON.stringify(dados))
    
    return true
        
}
function getDadosUsuarioLocal(){
    let usuarioString = localStorage.getItem('dadosUsuario')
    let usuarioObj = JSON.parse(usuarioString)

    return usuarioObj

}
async function deleteDadosUsuario(){
    localStorage.removeItem('dadosUsuario')

}

export {getDadosUsuarioLocal,
        dadosUsuarioPreview,
        deleteDadosUsuario}