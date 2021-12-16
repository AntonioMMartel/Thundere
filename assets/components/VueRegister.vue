<template>
    <div class="login">
        <h1 class="title"> Make an account</h1>
        <form class="form" @submit.prevent="register">

            <label class="form-label" for="#username">Username:</label>
            <input v-model="username" class="form-input" id="username" required placeholder="Username">

            <label class="form-label" for="#email">Email:</label>
            <input v-model="email" class="form-input" type="email" id="email" required placeholder="Email">

            <label class="form-label" for="#password">Password:</label>
            <input v-model="password" class="form-input" type="password" id="password" placeholder="Password">

            <label class="form-label" for="#password-repeat"> Repeat your password:</label>
            <input v-model="passwordRepeat" class="form-input" type="password" id="password-repeat" placeholder="Password">

            <p v-if="error" class="error"> {{ errorMessage }} </p>
            <input class="form-submit" type="submit" value="Register">
        </form>
    </div>
</template>

<script>
    import {register} from "../facade/AuthorizationFacade";

    export default {
        data: () => ({
            email: "",
            password: "",
            passwordRepeat: "",
            username: "",
            error: false,
            errorMessage: ""
        }),
        methods: {
          register() {
            register(this.email, this.username, this.password)
            .then(response => {console.log(response); window.location.href = '/login';})
            .catch((error) => {console.log(error); this.error=true; this.errorMessage=error.message});
            // Deberia redirigir a algo de confirmar usuario con su codigo que le llega al email
            
          }
        }
    };
</script>

<style lang="scss" scoped>
.login {
  padding: 2rem;
}
.title {
  text-align: center;
  color: $primary-color;
}
.form {
  margin: 3rem auto;
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