<template>
  <div class="container-main">
    <FadingLightsAnimation />
    <div class="container-ui">
      <div class="title">{{ input }}</div>
    </div>
  </div>
</template>

<script>
import CountrySearchInput from "../components/CountrySearchInput.vue";
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import { search } from "../../facade/SearchFacade";

export default {
  name: "SearchResults",
  components: { FadingLightsAnimation, CountrySearchInput },
  props: ["input"],
  methods: {

  },
  beforeMount() {
    console.log(search(this.input));
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
    padding-top: 1.2em;
  }
}
</style>
