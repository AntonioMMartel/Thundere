<template>
  <div class="all-container">
    <img v-if="Object.keys(this.data).length > 8" v-on:click="decreasePageCounter()" class="page-arrow left-arrow button" src="../../../svgs/ArrowLeft.svg" />
    <div class="flex">

      <div v-if="data" class="data-container">
        <div class="data-view" v-for="(data, key) in  Object.entries(data).slice(page * 8, (page + 1) * 8)" 
              :key="key" :id="key">
          <div class="data-title"> {{ data[0] }} 
          </div>
          <div class="data-content" v-if="typeof(data[1]) === 'string' || typeof(data[1]) === 'number'">
            {{ data[1] }}
          </div> 
          <div class="data-content" v-if="typeof(data[1]) === 'boolean'">
            {{ data[1]? true : false }}
          </div> 

          <div class="data-content-array" v-if="data[1] instanceof Array">
            <DynamicArrayViewer :array="data[1]"></DynamicArrayViewer> 
          </div>

          <div class="data-content-object" v-else-if="typeof(data[1]) === 'object'">
            <DynamicObjectViewer :data="data[1]"></DynamicObjectViewer> 
          </div>
        </div>        
      </div>
      <div v-if="Object.keys(data).length > 8" class="page-display">
        {{ page + 1 }}
      </div>
    </div>
    <img v-if="Object.keys(this.data).length > 8" v-on:click="increasePageCounter()" class="page-arrow right-arrow button" src="../../../svgs/ArrowRight.svg" />
  </div>
</template>

<script>
import DynamicArrayViewer from './DynamicArrayViewer.vue';
import DynamicObjectViewer from './DynamicObjectViewer.vue';

export default {
    name: "GeneralDataViewer",
    data() {
      return {
        error: false,
        errorMessage: "Ha habido un error inesperado",
        textRows: 1,
        page: 0
      };
    },
    props: ["data"],
    methods: {
    decreasePageCounter() {
      if (this.page - 1 < 0) {
        this.page = Math.ceil(Object.keys(this.data).length / 8) - 1;
      } else {
        this.page--;
      }
    },
    increasePageCounter() {
      if (this.page + 1 >= Math.ceil(Object.keys(this.data).length / 8)) {
        this.page = 0;
      } else {
        this.page++;
      }
    },

    },
    components: { DynamicArrayViewer, DynamicObjectViewer }
};
</script>

<style lang="scss" scoped>

.all-container {
  display: flex;
  flex-direction: row;

}

.data-content-array {
  font-size: 1.25rem;
  margin-left: auto;
  margin-right: auto;
  margin-top: 0.5em;
  width: 50%;
}

.data-content-object {
  font-size: 1.25rem;
  margin-top: 0.5em
}

.data-content {
  text-align: center;
  font-size: 1.25rem;
  margin-top: 0.5em

}
.data-title {
  font-size: 1.75rem;
  text-align: center;
  text-transform: capitalize;
  margin-top: 0.75em
}

.flex {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.data-container {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 20px;
  justify-content: center;
  justify-items: center;
}

.data-view{
  background-color: rgba(20, 20, 20, 0.788);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  border-radius: 15px;
  width: 250px;
  height: 250px;
}

.page-display {
  font-size: 1.75rem;
  text-align: center;
  position: absolute;
  top: 90vh;
  left: 0;
  bottom: 0;
  right: 0;
}

.button {
  cursor: pointer;
}
.icons {
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
.page-arrow {
  margin-top: 7em;
  height: 60px;
  width: 30px
}

.left-arrow {
  margin-right: 4em;
}

.right-arrow {
  margin-left: 4em;
}

.container-ui {
  width: 100%;
  height: 80vh;
  display: flex;
  
}


</style>
