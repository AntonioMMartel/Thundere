<template>
  <div class="container-main">
    <FadingLightsAnimation />
    <div class="container-ui">
      <div data-test="title" class="title"> Thundere </div>
      <CountrySearchInput :inputValue="inputValue" :to="'/search'" />
      <FiltersMenu></FiltersMenu>
    </div>
  </div>
</template>

<script>
import CountrySearchInput from "../components/CountrySearchInput.vue";
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import FiltersMenu from "../components/FiltersMenu.vue";

export default {
  name: "Home",
  components: { FadingLightsAnimation, CountrySearchInput, FiltersMenu },
  data () {
    return {
      inputValue: ""
    }
  }
};
</script>

<style lang="scss" scoped>
.title {
  font-size: 7rem;
  text-align: center;
}

.container-main {
  display: flex;
  height: 80vh;
  flex-wrap: wrap;
  color: $primary-color;
}

.container-ui {
  width: 100%;
  height: 80vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  div:first-child {
    padding-bottom: 0.3em;
    padding-top: 0.4em;
  }
}
</style>
