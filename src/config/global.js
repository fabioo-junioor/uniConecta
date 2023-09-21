const url = 'http://localhost/uniconecta/'

function setDadosUsuario(dados){
    localStorage.setItem('dadosUsuario', JSON.stringify(dados))
    
    return true
        
}
function getDadosUsuario(){
    let usuarioString = localStorage.getItem('dadosUsuario')
    let usuarioObj = JSON.parse(usuarioString)

    return usuarioObj

}
function deleteDadosUsuario(){
    localStorage.removeItem('dadosUsuario')

}

export {url, getDadosUsuario, setDadosUsuario, deleteDadosUsuario}