<template>
  <article>
    <div class="container-main">
      <FadingLightsAnimation />
      <div class="container-ui">
        <div class="title capitalize">{{ name || "Loading" }}</div>
        <div class="select-container">
          <img v-on:click="moveTargetBackwards()" class="arrow button" src="../../../svgs/ArrowLeft.svg" />
          <div class="select texto">{{  types[typeSelector] || "Loading data..." }}</div>
          <img v-on:click="moveTargetForwards()" class="arrow button" src="../../../svgs/ArrowRight.svg" />
        </div>
        <GeneralDataViewer :data="data[types[typeSelector]]"></GeneralDataViewer>

      </div>
    </div>
  </article>
</template>

<script>
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import GeneralDataViewer from "../components/GeneralDataViewer.vue";

import { view } from "../../facade/SearchFacade";

export default {
  name: "CountryViewer",
  components: { FadingLightsAnimation, GeneralDataViewer },
  data() {
    return {
      data: [],
      types: ["General", "Weather"],
      typeSelector: 0,
      name: "Loading"
    };
  },
  props: ["country"],
  beforeMount() {
    view(this.country, this.types)
      .then((response) => {
        this.data = response.data;
        console.log(this.data)
        this.name = this.data.General.name.common
      })
      .catch((error) => {
        console.log(error);
        this.error = "Error";
      });
  },
};
</script>

<style lang="scss" scoped>

.button {
  cursor: pointer;
}
.icons {
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
.page-arrow {
  height: 50%;
  margin-right: 1em;
  margin-left: 1em;
}
.arrow {
  margin: 1.5em;
}

.select {
  text-align: center
}
.title {
  font-size: 4rem;
  text-align: center;
  padding-top: 0.25em;
}
.capitalize {
  text-transform: capitalize;
}
.container-main {
  display: flex;
  min-height: 80vh;
  height: auto;
  flex-wrap: wrap;
  color: $primary-color;
}

.select-container {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding-bottom: 1em;
  padding-top: 0.2em;
}

.container-ui {
  width: 100%;
  height: 80vh;
  flex-direction: column;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.texto {
  font-size: 2rem;
}
</style>
