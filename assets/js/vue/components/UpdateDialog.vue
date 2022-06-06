<template>
  <div class="dialog-container">
    <div class="dialog-area"></div>
    <div class="dialog-body">
      <form class="form" action="/login" method="post" @submit.prevent="login">
        <div v-on:click="closeDialog()" class="form-title">{{ target }}</div>
        <label class="form-label" for="#email"> Email: </label>
        <input name="email" class="form-input" type="email" id="email" required placeholder="Email" />

        <label class="form-label" for="#password">Password:</label>
        <input name="password" class="form-input" type="password" id="password" placeholder="Password" />

        <p v-if="error" class="error">{{ errorMessage }}</p>
        <input class="form-submit" type="submit" value="Login" />
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "UpdateDialog",
  data() {
    return {
      input: "",
      error: false,
      errorMessage: "Ha habido un error inesperado",
    };
  },
  methods: {
    closeDialog() {
      this.$emit("closeDialog");
    },
  },
  props: ["data", "target"],
};
</script>

<style lang="scss" scoped>
.dialog-area {
  background: rgba(0, 0, 0, 0.3);
  min-width: 100vw;
  min-height: 100vh;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  box-shadow: inset 0 0 2000px rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(1px);
}

.dialog-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.dialog-body {
  z-index: 10;
  width: 65vw;
  height: 80vh;
  background-color: rgba(19, 35, 47);
  box-shadow: none;
  border-radius: 20px;
  color: $primary-color;
  box-shadow: 0 4px 10px 4px rgba(0, 0, 0, 0.3);
}

.title {
  padding-top: 2rem;
  text-align: center;
  color: $primary-color;
}
.form {
  margin: 0.5em auto 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  // width: 20%;
  // min-width: 350px;
  // max-width: 100%;
  border-radius: 5px;
  padding: 40px;
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
