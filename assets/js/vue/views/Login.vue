<template>
  <div class="login">
    <h1 class="title">Login in to the page</h1>
    <form class="form" action="/login" method="post" @submit.prevent="login">
      <label class="form-label" for="#email">Email:</label>
      <input v-model="email" name="email" class="form-input" type="email" id="email" required placeholder="Email" />

      <label class="form-label" for="#password">Password:</label>
      <input v-model="password" name="password" class="form-input" type="password" id="password" placeholder="Password" />

      <p v-if="error" class="error">{{ errorMessage }}</p>
      <input class="form-submit" type="submit" value="Login" />

      <!-- <input type="hidden" name="_csrf_token"> -->
    </form>
  </div>
</template>

<script>
import { login } from "../../facade/AuthorizationFacade";
export default {
  name: "Login",
  data: () => ({
    email: "",
    password: "",
    error: false,
    errorMessage: "",
    loginSuccess: null,
  }),
  methods: {
    // Pq funciona esto?
    // Symfony no está renderizando vue. Solo renderiza la primera pg y desde ahi vue se busca la vida
    // La autenticación en Symfony funciona con eventos QUE SE EJECUTAN CUANDO SE RENDERIZAN PAGS EN SYMFONY
    // Basicamente cuando la autenticación es exitosa recargamos el componente llamando a symfony de nuevo.
    login() {
      login(this.email, this.password, this._csrf_token)
        .then((response) => {
          this.reloadComponent();
          window.location.replace("/");
        })
        .catch((error) => {
          this.error = true;
          this.errorMessage = error;
        });
      // Deberia redirigir a algo de confirmar usuario con su codigo wapo
    },

    reloadComponent() {
      this.$forceUpdate(); // Recargamos el componente -> Se vuelve a llamar a symfony
    },
  },
};
</script>

<style lang="scss" scoped>
.login {
  height: 77.5vh;
  color: $primary-color;
}

.title {
  padding-top: 2rem;
  text-align: center;
  color: $primary-color;
}
.form {
  margin: 3rem auto 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 20%;
  min-width: 350px;
  max-width: 100%;
  background: rgba(19, 35, 47, 0.9);
  border-radius: 5px;
  padding: 40px;
  box-shadow: 0 4px 10px 4px rgba(0, 0, 0, 0.3);
}
.form-label {
  margin-top: 2rem;
  color: white;
  margin-bottom: 0.5rem;
  &:first-of-type {
    margin-top: 0rem;
  }
}
.form-input {
  padding: 10px 15px;
  background: none;
  background-image: none;
  border: 1px solid white;
  color: white;
  &:focus {
    outline: 0;
    border-color: #1ab188;
  }
}
.form-submit {
  background: #1ab188;
  border: none;
  color: white;
  margin-top: 3rem;
  padding: 1rem 0;
  cursor: pointer;
  transition: background 0.2s;
  &:hover {
    background: #0b9185;
  }
}
</style>
