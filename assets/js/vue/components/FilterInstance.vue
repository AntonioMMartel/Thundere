<template>
  <div class="filter-container">
    <select ref="typeInput" @change="changeType" class="input" value="General" name="data-type" >
      <option  class="option" v-for="(option, key) in types" :key="key" :value="option"> {{ option }}</option>
    </select>
    <div v-if="selectedType !== 'Weather'" class="flex" >
      <select ref="dataFilterInput" @change="changeDataFilter" class="input" name="data-type" >
        <option class="option" v-for="(option, key) in selectedDataKeys" :key="key" :value="option"> {{ option }}</option>
      </select>
      <select class="input" name="data-type" >
        <option class="option" v-for="(option, key) in condition[typeof(selectedData)]" :key="key" :value="option"> {{ option }}</option>
      </select>
      <input autocomplete="no" type="text" class="input" name="data-type" >
    </div>
    <img class="delete-icon" @click="deleteFilter" src="../../../svgs/Trash.svg" alt="Delete filter" />
  </div>
</template>

<script>
export default {
  name: "FilterInstance",
  data() {
    return {
      types: ["General", "Weather"],
      condition: {
        "number": ["contains", "equals", "starts with", "ends with", "lower than", "higher than", "lower or equal than", "higher or equal than"],
        "object": ["contains"],
        "string": ["contains", "equals", "starts with", "ends with"],
      },
      selectedType: "General",
      selectedDataFilter: "name",
      selectedDataKey: 0
    };
  },
  props: ["index", "data"],
  methods: {
    changeType() {
      this.selectedType = this.$refs.typeInput.value;
    },
    changeDataFilter() {
      this.selectedDataFilter = this.$refs.dataFilterInput.value;
    },
    deleteFilter() {
      this.$emit('deleteFilter', this.index)
    }
  },
  computed: {
    selectedDataKeys() {
      return Object.keys(this.data[this.selectedType]);
    },
    selectedData() {
      return (this.data[this.selectedType][this.selectedDataFilter])
    }
  }
};
</script>

<style lang="scss" scoped>

.delete-icon {
  cursor: pointer;
  margin-top: 0.4em;
}

.flex {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.filter-container {
  margin: 1em;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 170px;
  width: 170px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  border-radius: 20px;
  background-color: rgba(255, 255, 255, 0.1);
  &:hover {
    background-color: rgba(255, 255, 255, 0.13);
  }
}

.input {
  background-color: rgba(255, 255, 255, 0.15);
  border-radius: 20px;
  border-width: 0;
  margin-top: 1em;
  border-color: $primary-color;
  &:hover {
    background-color: rgba(255, 255, 255, 0.2);
  }
  outline: none;
  padding: 0.12em;
  text-align: center;
  width: 120px
}

option {
  background-color: #363636;
  box-shadow: none;
  border-radius: 20px;
  border-width: 0;
}

</style>