<template>
  <span v-on:wheel="modifyPointer($event)" class="container">
    {{ this.data.this.keys[pointer] }}
    <img class="unselectable" src="../../../svgs/ArrowsUpDown.svg" alt="" />
  </span>
</template>

<script>
export default {
  name: "CountrySearchInput",
  data() {
    return {
      pointer: 0,
      keys: [],
    };
  },
  props: ["data"],
  methods: {
    async sleep(ms) {
      return await new Promise((resolve) => setTimeout(resolve, ms));
    },
    modifyPointer(event) {
      // Hacia arriba
      if (event.deltaY < 0) {
        if (this.pointer + 1 >= this.keys.length) {
          this.pointer = 0;
        } else {
          this.pointer++;
        }
      } else {
        if (this.pointer - 1 < 0) {
          this.pointer = this.keys.length - 1;
        } else {
          this.pointer--;
        }
      }
    },

  },
  beforeMount() {
    this.keys = Object.keys(data);
  }

};
</script>

<style lang="scss" scoped>
.container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
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
