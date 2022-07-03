<template>
  
</template>

<script>
export default {
  name: "Filter",
  data() {
    return {
      inputValue: "",
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

</style>