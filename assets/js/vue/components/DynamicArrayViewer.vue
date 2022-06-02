<template>
  <span v-on:wheel.up="increasePointer()" v-on:wheel.down="decreasePointer()" class="container">
    {{ this.array[this.pointer] }}
    <img class="unselectable" src="../../../svgs/ArrowsUpDown.svg" alt="" />
  </span>
</template>

<script>
export default {
  name: "CountrySearchInput",
  data() {
    return {
      array: [],
      pointer: 0,
    };
  },
  props: ["array"],
  methods: {
    async sleep(ms) {
      return await new Promise((resolve) => setTimeout(resolve, ms));
    },
    increasePointer() {
      console.log("AAA");
      this.pointer + 1 >= this.array.length ? (this.pointer = 0) : this.pointer++;
    },
    decreasePointer() {
      this.pointer - 1 < 0 ? (this.pointer = this.array.length) : this.pointer--;
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
