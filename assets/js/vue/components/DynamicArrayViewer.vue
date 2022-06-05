<template>
  <span v-on:wheel="modifyPointer($event)" class="container">
    {{ this.array[this.pointer] }}
    <img class="unselectable" src="../../../svgs/ArrowsUpDown.svg" alt="" />
  </span>
</template>

<script>
export default {
  name: "CountrySearchInput",
  data() {
    return {
      pointer: 0,
    };
  },
  props: ["array"],
  methods: {
    async sleep(ms) {
      return await new Promise((resolve) => setTimeout(resolve, ms));
    },
    modifyPointer(event) {
      // Hacia arriba
      if (event.deltaY < 0) {
        if (this.pointer + 1 >= this.array.length) {
          this.pointer = 0;
        } else {
          this.pointer++;
        }
      } else {
        if (this.pointer - 1 < 0) {
          this.pointer = this.array.length - 1;
        } else {
          this.pointer--;
        }
      }
    },
  },
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
