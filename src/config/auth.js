import bcryptjs from 'bcryptjs'

async function encryptSenha(senha){
    try{
        const hash = await bcryptjs.hash(senha, 10)
        
        return hash

    } catch(e){
        console.log(e)

    }
}
async function decryptSenha (senha, hash){
    try{
        const validPass = await bcryptjs.compare(senha, hash)
        if(validPass){
            return true

        }else{
            return false

        }
    }catch(e){
        console.log(e)

    }
}

export { encryptSenha, decryptSenha }