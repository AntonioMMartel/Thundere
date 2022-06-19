<template>
  <div class="dialog-container">
    <div v-on:click="closeDialog()" class="dialog-area"></div>
    <div class="dialog-body">
      <div class="form">
        <div v-if="dialogIsUpdating" class="form-title">Editing {{ target }}</div>
        <div v-if="!dialogIsUpdating" class="form-title">Adding {{ target }}</div>
        <div v-for="(field, label) in data" :key="label" class="field-container">
          <label class="form-label" :for="field"> {{ label }} </label>
          <input v-on:blur="saveInput(label)" v-if="typeof(field) === 'string' && label !== 'Password'" required :name="label" :id="label" class="form-input" type="text" :value="field" />
          <input v-on:blur="saveInput(label)" v-if="typeof(field) === 'number'" required :name="label" :id="label" class="form-input" type="number" :value="field" />          
          <input v-on:blur="saveInput(label)" v-if="label === 'Password'" required :name="label" :id="label" class="form-input" type="password" :value="field" />          
          <div v-if="field instanceof Array">
           <DynamicArrayUpdater @arrayUpdated="updateArray" :label="label" :array="field"></DynamicArrayUpdater>
          </div>
        </div>

        <p v-if="error" class="error">{{ errorMessage }}</p>
        <div class="text-center"> {{ message }}</div>
        <div class="dialog-buttons">
          <button class="button cancel" v-on:click="closeDialog()">Cancel</button>
          <button v-if="dialogIsUpdating" class="button confirm" v-on:click="updateTarget(id, target)"> Confirm </button>
          <button v-if="!dialogIsUpdating" class="button confirm" v-on:click="addTarget(target)"> Add </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DynamicArrayUpdater from './DynamicArrayUpdater.vue';
import { search } from '../../facade/SearchFacade';
import { updateCountryById, updateUseryById, addUser, addCountry } from  '../../facade/AdminFacade.js';
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

      // Añadimos la zona horaria del usuario para registrar cambios
      Object.assign(
            this.data, {
              "clientTimeOffset": new Date().getTimezoneOffset() 
            } 
          )
      if(target === "Countries" ) updateCountryById(id, this.data)
      if(target === "Users" ) updateUseryById(id, this.data)
      this.closeDialog();
    },
    updateArray(newArray, label) {
      this.data[label] = newArray
    },
    addTarget(target){
      for (const label in this.data) {
        if (!(this.data[label] instanceof Array)){
            this.data[label] = document.getElementById(label).value;
        }
      }
      Object.assign(
            this.data, {
              "clientTimeOffset": new Date().getTimezoneOffset() 
            } 
          )
      if(target === "Countries" ){
        if (this.mode === "Add one normally")
          addCountry(this.data)

        if (this.mode === "Add one using api")
          search(this.data["Name"], ["General"]);

      } 
      if(target === "Users" ) addUser(this.data)
      this.closeDialog();

    },
    saveInput(label) {
      this.data[label]=document.getElementById(label).value
    }
  },
  props: ["data", "target", "id", "dialogIsUpdating", "message", "mode"],
};
</script>

<style lang="scss" scoped>

.text-center {
  text-align: center;
}
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
