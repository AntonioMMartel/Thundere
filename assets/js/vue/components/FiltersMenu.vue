<template>
  <div class="filters-container">
    <img v-on:click="addNewFilter()" class="add button" src="../../../svgs/add.svg" />
    <div class="filters-grid">
      <div v-for="(filter, key) in filters" :key="key">
        <Filter :key="key" :filter="filter"></Filter>
      </div>
    </div>
  </div>
</template>

<script>
import Filter from "./Filter.vue";
export default {
    name: "FiltersMenu",
    data() {
        return {
            inputValue: "",
            filters: [],
        };
    },
    methods: {
        addNewFilter() {
            this.filters.push({});
        }
    },
    components: { Filter }
};
</script>

<style lang="scss" scoped>

.filters-container {
  margin-top: 2em;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.add {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  width: 50px;
  height: 50px;
  border-radius: 100px;
  background-color: rgba(255, 255, 255, 0.1);
  &:hover {
    background-color: rgba(255, 255, 255, 0.2);
  }
}

.button {
  cursor: pointer;
}

</style>