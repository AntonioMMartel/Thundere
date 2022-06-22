<template>
  <article>
    <div class="container-main">
      <FadingLightsAnimation />
      <div class="container-ui">
        <div class="title capitalize">{{ country }}</div>
        <div class="texto">{{ message }}</div>
      </div>
    </div>
  </article>
</template>

<script>
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import { view } from "../../facade/SearchFacade";

export default {
  name: "CountryViewer",
  components: { FadingLightsAnimation },
  data() {
    return {
      data: [],
      message: "Loading data...",
    };
  },
  props: ["country"],
  beforeMount() {
    view(this.country, ["General"])
      .then((response) => {
        this.data = response.data;
      })
      .catch((error) => {
        console.log(error);
        this.error = "Error";
      });
  },
};
</script>

<style lang="scss" scoped>
.title {
  font-size: 4rem;
  text-align: center;
  padding-bottom: 0.3em;
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
