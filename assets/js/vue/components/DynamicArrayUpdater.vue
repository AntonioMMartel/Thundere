<template>
  <div v-on:wheel="modifyPointer($event)" class="container">
    {{ this.array[this.pointer] }}

    <img class="unselectable" src="../../../svgs/ArrowsUpDown.svg" alt="" />
    <input name="input" id="form-input" type="text" :value="this.array[this.pointer]" />
    <img v-on:click="confirmChanges()" class="confirm-button" src="../../../svgs/Tic.svg" />
  </div>
</template>

<script>
export default {
  name: "DynamicArrayUpdater",
  data() {
    return {
      pointer: 0,
    };
  },
  props: ["array", "label"],
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
    confirmChanges(){
      this.array[this.pointer] = document.getElementById("form-input").value;
      this.$emit('arrayUpdated', this.array, this.label)
    }
  },
};
</script>

<style lang="scss" scoped>
.confirm-button {
  margin: 10px;
  height: 20px;
  cursor: pointer;
}

.container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}

#form-input {
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

.unselectable {
  user-select: none;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  -webkit-user-drag: none;
  margin: 10px;
}
</style>
