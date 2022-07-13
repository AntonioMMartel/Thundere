<template>
  <div class="filters-container">
    <img v-if="dataIsPrepared" v-on:click="addNewFilter()" class="add button" src="../../../svgs/add.svg" />
    <div v-if="dataIsPrepared" class="filters-grid">
    
      <div ref="filters" v-if="filters[key]" :class="filterClass" v-for="(index, key) in filters" :key="key">
        <FilterInstance  ref="key" @deleteFilter="deleteFilter" :data="data" :index="key"></FilterInstance>
      </div>
    </div>
  </div>
</template>

<script>
import FilterInstance from "./FilterInstance.vue";
import { view } from "../../facade/SearchFacade";

export default {
  name: "FiltersMenu",
  data() {
    return {
      filters: [false,
                false,
                false,
                false,
                false,
                false,
                false,
                false,
                false,
                false,
                ],
      data: {},
      dataIsPrepared: false,
      filterClass: "filter"
    };
  },
  methods: {
    addNewFilter() {
      if(this.filters.indexOf(false) !== -1) {
        this.filters.splice(this.filters.length)
        this.filters[this.filters.indexOf(false)] = true
      }
    } ,
    deleteFilter(index) {
      this.filters.splice(this.filters.length)
      this.filters[index] = false
    }
  },
  beforeMount() {
    view("Morocco", ["General", "Weather"])
      .then((response) => {
        this.data = response.data;
        this.dataIsPrepared = true
      })
      .catch((error) => {
        console.log(error);
        this.error = "Error";
      });
  },
  components: { FilterInstance }
};
</script>

<style lang="scss" scoped>


.filters-grid {
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  margin-top: 1.5em;
}

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