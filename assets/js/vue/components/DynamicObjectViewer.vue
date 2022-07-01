<template>
  <div class="all-container">

    <!-- First -->
    <div v-on:wheel="modifyPointer($event, 'First', keys)">
      <div class="data-view" v-if="typeof(data[keys[pointer]]) === 'string' || typeof(data[1]) === 'number'" >
        {{ keys[pointer] }}: {{ data[keys[pointer]] }}
      </div>
      <div v-if="typeof(data[keys[pointer]]) === 'boolean'">
        {{ keys[pointer] }}: {{ data[keys[pointer]] ? true : false }}
      </div>

      <div class=" data-view data-content-array" v-if="data[keys[pointer]] instanceof Array">
        {{ keys[pointer] }}: <DynamicArrayViewer :array="data[keys[pointer]]"></DynamicArrayViewer> 
      </div>
    </div>

    <!-- Second -->
    <div class="data-view" v-if="typeof(secondData) === 'object'">
      <div v-on:wheel="modifyPointer($event, 'First', keys)">
        {{ keys[pointer] }}
      </div>
      <div class="all-container second-data-view">
        <div v-on:wheel="modifyPointer($event, 'Second', secondKeys)">
          <div class="data-view" v-if="typeof(secondData[secondKeys[secondPointer]]) === 'string' || typeof(data[1]) === 'number'" >
            {{ secondKeys[secondPointer] }}: {{ secondData[secondKeys[secondPointer]] }}
          </div>
          <div v-if="typeof(secondData[secondKeys[secondPointer]]) === 'boolean'">
            {{ secondKeys[secondPointer] }}: {{ secondData[secondKeys[secondPointer]] ? true : false }}
          </div>

          <div class=" data-view data-content-array" v-if="secondData[secondKeys[secondPointer]] instanceof Array">
            <DynamicArrayViewer :array="secondData[secondKeys[secondPointer]]"></DynamicArrayViewer> 
          </div>
        </div>
        <div class="data-view" v-if="typeof(thirdData) === 'object'">
            <div class="second-data-view" v-on:wheel="modifyPointer($event, 'Second', secondKeys)">
              {{ secondKeys[secondPointer] }}
            </div>
            <div class="third-data-view all-container" v-on:wheel="modifyPointer($event, 'Third', thirdKeys)">
          
              <div class="data-view" v-if="typeof(thirdData[thirdKeys[thirdPointer]]) === 'string' || typeof(data[1]) === 'number'" >
                {{ thirdKeys[thirdPointer] }}: {{ thirdData[thirdKeys[thirdPointer]] }}
              </div>
              <div v-if="typeof(thirdData[thirdKeys[thirdPointer]]) === 'boolean'">
                {{ thirdKeys[thirdPointer] }}: {{ thirdData[thirdKeys[thirdPointer]] ? true : false }}
              </div>

              <div class=" data-view data-content-array" v-if="thirdData[thirdKeys[thirdPointer]] instanceof Array">
                <DynamicArrayViewer :array="thirdData[thirdKeys[thirdPointer]]"></DynamicArrayViewer> 
              </div>   
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DynamicArrayViewer from './DynamicArrayViewer.vue';


export default {
  name: "CountrySearchInput",
  data() {
    return {
      pointer: 0,
      keys: [],
      secondPointer: 0,
      thirdPointer: 0
    };
  },
  props: ["data"],
  components: { DynamicArrayViewer},
  methods: {
    async sleep(ms) {
      return await new Promise((resolve) => setTimeout(resolve, ms));
    },
    modifyPointer(event, pointerSelector, keys) {
      if(pointerSelector === "First"){
        // Hacia arriba
        if (event.deltaY < 0) {
          if (this.pointer + 1 >= keys.length) {
            this.pointer = 0;
          } else {
            this.pointer++;
          }
        } else {
          if (this.pointer - 1 < 0) {
            this.pointer = keys.length - 1;
          } else {
            this.pointer--;
          }
        }
      
      } else if(pointerSelector === "Second"){

        if (event.deltaY < 0) {
          if (this.secondPointer + 1 >= keys.length) {
            this.secondPointer = 0;
          } else {
            this.secondPointer++;
          }
        } else {
          if (this.secondPointer - 1 < 0) {
            this.secondPointer = keys.length - 1;
          } else {
            this.secondPointer--;
          }
        }

      } else if (pointerSelector === "Third") {

        if (event.deltaY < 0) {
          if (this.thirdPointer + 1 >= keys.length) {
            this.thirdPointer = 0;
          } else {
            this.thirdPointer++;
          }
        } else {
          if (this.thirdPointer - 1 < 0) {
            this.thirdPointer = keys.length - 1;
          } else {
            this.thirdPointer--;
          }
        }


      }
    },
    getKeys(data) {
      return Object.keys(data);
    },

  },
  created() {
    console.log("O")
    this.keys = Object.keys(this.data);
  },
  computed: {
    secondKeys() {
      return this.getKeys(this.data[this.keys[this.pointer]]);
    },
    secondData() {
      return this.data[this.keys[this.pointer]];
    },
    thirdKeys() {
      return this.getKeys(this.secondData[this.secondKeys[this.secondPointer]]);

    },
    thirdData() {
      return this.secondData[this.secondKeys[this.secondPointer]];
    }

  }
};
</script>

<style lang="scss" scoped>
.dynamic-container {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}


.data-view {
  margin-left: 1em;
  margin-right: 1em;
  text-align: center;
}

.all-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.unselectable {
  user-select: none;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  -webkit-user-drag: none;
  margin: 10px;
}
</style>
