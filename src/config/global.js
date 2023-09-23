function dadosUsuarioPreview(pk_usuario){
    fetch(import.meta.env.VITE_ROOT_API+'buscaDadosUsuario.php?dadosPreview=1', {
        method: 'POST',
        body: JSON.stringify({
            pk_usuario: pk_usuario
        })
      })
      .then((res) => res.json())
      .then((dados) => {
        //console.log("--> ", dados)
        setDadosUsuarioLocal(dados)

    })
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
function deleteDadosUsuario(){
    localStorage.removeItem('dadosUsuario')

}

export {getDadosUsuarioLocal,
        dadosUsuarioPreview,
        deleteDadosUsuario}