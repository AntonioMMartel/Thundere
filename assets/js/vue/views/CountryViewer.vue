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
import { search } from "../../facade/SearchFacade";

export default {
  name: "CountryViewer",
  components: { FadingLightsAnimation },
  data() {
    return {
      data: "",
      message: "Loading data...",
    };
  },
  props: ["country"],
  beforeMount() {
    console.log(this.country);
    search(this.country)
      .then((response) => {
        this.data = response.data;
        this.message = this.data.cca2;
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
  font-size: 7rem;
  text-align: center;
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

  display: flex;
  flex-direction: column;
  align-items: center;

  div:first-child {
    padding-bottom: 0.3em;
    padding-top: 1.2em;
  }
}

.texto {
  font-size: 2rem;
}
</style>
