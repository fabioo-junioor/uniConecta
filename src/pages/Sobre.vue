<script>
export default {
  name: "Sobre",
  data() {
    return {
      totalUsuarios: 0,
      totalCursos: 0,
      url: null,
    };
  },
  methods: {
    async buscarTodosUsuarios() {
      const response = await fetch(
        this.url + "dadosTotais.php?totalUsuarios=1",
        {
          method: "POST",
          body: JSON.stringify(),
        }
      );
      if (!response.ok) {
        console.log(response.status);
      } else {
        const dados = await response.json();
        this.totalUsuarios = await dados[0].totalUsuario;
      }
    },
    async buscarTodosCursos() {
      const response = await fetch(this.url + "dadosTotais.php?totalCursos=1", {
        method: "POST",
        body: JSON.stringify(),
      });
      if (!response.ok) {
        console.log(response.status);
      } else {
        const dados = await response.json();
        this.totalCursos = dados[0].totalCurso;
      }
    },
  },
  async mounted() {
    this.url = import.meta.env.VITE_ROOT_API;
    await this.buscarTodosUsuarios();
    await this.buscarTodosCursos();
  },
};
</script>

<template>
  <div id="sobre">
    <div class="dados-pagina-sobre">
      <div class="dados-qtd-user">
        <h5>Total Usuários</h5>
        <i class="bx bx-user-pin"></i>
        <span>{{ totalUsuarios }}</span>
      </div>
      <div class="dados-qtd-cursos">
        <h5>Total Cursos</h5>
        <i class="bx bx-meteor"></i>
        <span>{{ totalCursos }}</span>
      </div>
    </div>
    <div class="info-pagina-sobre">
      <h2>UniConecta</h2>
      <hr />
      <p>
        ??
      </p>
      <div class="contato">
        <i class="bx bx-envelope"></i>
        <span>fcjunior@inf.ufsm.br</span>
      </div>
    </div>
  </div>
</template>


<style lang="scss" scoped>
@import url("https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css");
@import url("https://fonts.googleapis.com/css2?family=Ubuntu&family=Work+Sans&display=swap");

#sobre {
  font-family: "Work Sans", sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 5rem 0 1rem 0;
  padding: 1rem 0;

  .dados-pagina-sobre {
    width: 60%;
    display: flex;
    justify-content: space-around;
    padding: 0 0 1.5rem 0;

    .dados-qtd-user {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 40%;
      padding: 1.5rem 0;
      border-radius: 5px;
      background-color: white;
      border: 1px solid #6c63ff;
      box-shadow: 2px 2px 0px 0px #6c63ff;

      h5 {
        font-size: 1.1rem;
        padding-bottom: 0.2rem;
      }
      i {
        color: black;
        font-size: 2.5rem;
      }
      span {
        font-size: 1.5rem;
      }
    }
    .dados-qtd-cursos {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 40%;
      padding: 1.5rem 0;
      border-radius: 5px;
      background-color: white;
      border: 1px solid #6c63ff;
      box-shadow: 2px 2px 0px 0px #6c63ff;

      h5 {
        font-size: 1.1rem;
        padding-bottom: 0.2rem;
      }
      i {
        color: black;
        font-size: 2.5rem;
      }
      span {
        font-size: 1.5rem;
      }
    }
  }
  .info-pagina-sobre {
    width: 65%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 0;
    margin: 2rem 0 0 0;

    h2 {
      color: black;
      font-weight: bold;
      color: #6c63ff;
    }
    hr {
      width: 100%;
      border: 1px solid #6c63ff;
    }
    p {
      text-align: justify;

      .text-bold{
        font-weight: bold;
        color: #6c63ff;

      }
    }
    .contato {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.5rem;

      i {
        color: black;
        font-size: 1.5rem;
        padding: 0 0.5rem;
      }
      span {
        font-size: 1rem;
      }
    }
  }
}
/* Responsive */
@media only screen and (max-width: 1560px) {
}
@media only screen and (max-width: 1200px) {
}
@media only screen and (max-width: 992px) {
  #sobre {
    .dados-pagina-sobre {
      width: 80%;
    }
    .info-pagina-sobre {
      width: 80%;
    }
  }
}
@media only screen and (max-width: 720px) {
  #sobre {
    .dados-pagina-sobre {
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0;
      width: 95%;

      .dados-qtd-user {
        width: 100%;
        margin: 0.3rem 0;
      }
      .dados-qtd-cursos {
        width: 100%;
        margin: 0.3rem 0;
      }
    }
    .info-pagina-sobre {
      width: 95%;
    }
  }
}
@media only screen and (max-width: 481px) {
}
@media only screen and (max-width: 360px) {
}
</style>