<template>
  <div class="container-main">
    <FadingLightsAnimation />
    <div class="container-ui">
      <div class="select-container">
        <img class="arrow" src="../../../svgs/ArrowRight.svg" />
        <div class="select capitalize">Countries</div>
        <img class="arrow" src="../../../svgs/ArrowLeft.svg" />
      </div>

      <table>
        <thead>
          <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Data</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="country in data" :key="country.id">
            <td>{{ country.isoCode }}</td>
            <td><DynamicArrayViewer :array="country.names"></DynamicArrayViewer></td>
            <td>Go to</td>
            <td class="unselectable">
              <img class="unselectable" src="../../../svgs/EditButton.svg" />
              <img class="unselectable" src="../../../svgs/Trashcan.svg" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import DynamicArrayViewer from "../components/DynamicArrayViewer.vue";
import { getAllCountries } from "../../facade/AdminFacade.js";
export default {
  name: "Admin",
  components: { FadingLightsAnimation, DynamicArrayViewer },
  data() {
    return {
      data: [],
      message: "Loading data...",
    };
  },
  beforeMount() {
    getAllCountries()
      .then((response) => {
        this.data = response.data.countries;
        console.log(this.data);
        this.message = "";
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style lang="scss" scoped>
.arrow {
  margin: 1.5em;
}
.select-container {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}
.select {
  font-size: 2.5rem;
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
  min-height: 80vh;

  display: flex;
  flex-direction: column;
  align-items: center;

  div:first-child {
    padding-bottom: 1em;
    padding-top: 0.2em;
  }
}

table {
  border-collapse: collapse;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  font-size: 1.2rem;
  user-select: text;
  -moz-user-select: text;
  -webkit-user-select: text;
  -ms-user-select: text;
  border-radius: 10px;
}

.unselectable {
  user-select: none;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  -webkit-user-drag: none;
}

th,
td {
  padding: 15px;
  background-color: rgba(255, 255, 255, 0.1);
  color: #fff;
}

th {
  text-align: left;
}

thead {
  th {
    background-color: rgba(255, 255, 255, 0.15);
  }
}

tbody {
  tr {
    &:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
  }
}
</style>
