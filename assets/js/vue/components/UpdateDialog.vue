<template>
  <div class="dialog-container">
    <div v-on:click="closeDialog()" class="dialog-area"></div>
    <div class="dialog-body">
      <div class="form">
        <div class="form-title">Editing {{ target }}</div>
        <div v-for="(field, label) in data" :key="label" class="field-container">
          <label class="form-label" for="#email"> {{ label }} </label>
          <input v-if="typeof(field) === 'string'" :name="field" :id="label" class="form-input" type="text" :value="field" />
          <input v-if="typeof(field) === 'number'" :name="field" :id="label" class="form-input" type="number" :value="field" />
          <div v-if="field instanceof Array">
           <DynamicArrayUpdater @arrayUpdated="updateArray()" :label="label" :array="field"></DynamicArrayUpdater>
          </div>
        </div>

        <p v-if="error" class="error">{{ errorMessage }}</p>
        <div class="dialog-buttons">
          <button class="button cancel" v-on:click="closeDialog()">Cancel</button>
          <button class="button confirm" v-on:click="updateTarget(id, target)">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DynamicArrayUpdater from './DynamicArrayUpdater.vue';
import { updateCountryById } from  '../../facade/AdminFacade.js';
export default {
  name: "UpdateDialog",
  data() {
    return {
      input: "",
      error: false,
      errorMessage: "Ha habido un error inesperado",
    };
  },
  components: {DynamicArrayUpdater},
  methods: {
    closeDialog() {
      this.$emit("closeDialog");
    },
    updateTarget(id, target) {
      // Cargamos todos los datos del formulario
      for (const label in this.data) {
        if (!(this.data[label] instanceof Array)){
          this.data[label] = document.getElementById(label).value;
        }
      }
      if(target === "Countries" ){
        updateCountryById(id, this.data)
      }
      this.closeDialog();
    },
    updateArray(newArray, label) {
      this.data[label] = newArray
    }
  },
  props: ["data", "target", "id"],
};
</script>

<style lang="scss" scoped>

.field-container {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.25em
}
.dialog-buttons {
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  align-items: center;
  height: fit-content;
  margin-top: 1.25em;
}
.form-title {
  align-self: center;
  font-size: 1.75rem;
  margin-bottom: 20px;
}
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
  align-self: flex-start;
  margin-top: 9em;
  z-index: 10;
  width: 65vw;
  max-width: 510px;
  max-height: 80vh;
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
  // width: 20%;
  // min-width: 350px;
  // max-width: 100%;
  border-radius: 5px;
  padding-left: 40px;
  padding-right: 40px;
  padding-top: 20px;
  padding-bottom: 30px;

  height: 100%;
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
.button {
  border: none;
  color: white;
  padding: 1rem 0;
  cursor: pointer;
  transition: background 0.2s;
  border-radius: 5px;
  padding: 1.2em;
}

.confirm {
  background: #1ab188;
  &:hover {
    background: #0b9185;
  }
}

.cancel {
  background: #dc3545;
  &:hover {
    background: #b52835;
  }
}
</style>
