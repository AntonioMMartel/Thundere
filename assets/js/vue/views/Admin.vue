<template>
  <div class="container-main">
    <FadingLightsAnimation />
    <div class="container-ui">
      <div class="select-container">
        <img v-on:click="moveTargetBackwards()" class="arrow button" src="../../../svgs/ArrowLeft.svg" />
        <div class="select capitalize title">{{ targets[targetSelector] }}</div>
        <img v-on:click="moveTargetForwards()" class="arrow button" src="../../../svgs/ArrowRight.svg" />
      </div>

      <table v-if="targets[targetSelector] == 'Countries'">
        <thead>
          <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Data</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="country in data['Countries'].slice(page * 5, page + 1 * 5)" :key="country._id.$oid" v-bind:id="country._id.$oid">
            <td>{{ country.isoCode }}</td>
            <td><DynamicArrayViewer :array="country.names"></DynamicArrayViewer></td>
            <td class="button">Go to</td>
            <td class="unselectable">
              <div class="icons">
                <img class="unselectable button" src="../../../svgs/EditButton.svg" />
                <img v-on:click="deleteCountry(country._id.$oid)" class="unselectable button" src="../../../svgs/Trashcan.svg" />
              </div>
            </td>
          </tr>
          <tr>
            <td v-on:wheel="changePageOnScroll($event)" class="unselectable" colspan="100%">
              <div class="page-display">
                <img v-on:click="decreasePageCounter()" class="page-arrow button" src="../../../svgs/ArrowLeft.svg" />
                {{ page + 1 }}
                <img v-on:click="increasePageCounter()" class="page-arrow button" src="../../../svgs/ArrowRight.svg" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <table v-if="targets[targetSelector] == 'Users'">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Confirmation Time</th>
            <th>Created Time</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in data['Users'].slice(page * 5, page + 1 * 5)" :key="user._id.$oid" v-bind:id="user._id.$oid">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td><DynamicArrayViewer :array="user.roles"></DynamicArrayViewer></td>
            <td>{{ longToDate(user.confirmation_time.$date.$numberLong) }}</td>
            <td>{{ longToDate(user.created_time.$date.$numberLong) }}</td>
            <td class="unselectable">
              <div class="icons">
                <img class="unselectable button" src="../../../svgs/EditButton.svg" />
                <img v-on:click="deleteUser(user._id.$oid)" class="unselectable button" src="../../../svgs/Trashcan.svg" />
              </div>
            </td>
          </tr>
          <tr>
            <td v-on:wheel="changePageOnScroll($event)" class="unselectable" colspan="100%">
              <div class="page-display">
                <img v-on:click="decreasePageCounter()" class="page-arrow button" src="../../../svgs/ArrowLeft.svg" />
                {{ page + 1 }}
                <img v-on:click="increasePageCounter()" class="page-arrow button" src="../../../svgs/ArrowRight.svg" />
              </div>
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
import { getAllCountries, deleteCountryByID, getAllUsers, deleteUserByID } from "../../facade/AdminFacade.js";
export default {
  name: "Admin",
  components: { FadingLightsAnimation, DynamicArrayViewer },
  data() {
    return {
      data: { Countries: [], Users: [] },
      message: "Loading data...",
      targets: ["Countries", "Users"],
      targetSelector: 0,
      page: 0,
      maxElements: 5,
    };
  },
  beforeMount() {
    getAllCountries()
      .then((response) => {
        this.data["Countries"] = response.data.countries;
      })
      .catch((error) => {
        console.log(error);
      });
    getAllUsers()
      .then((response) => {
        this.data["Users"] = response.data.users;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    deleteCountry(id) {
      if (confirm("This country and all its associated data will be deleted permanently."))
        deleteCountryByID(id)
          .then((response) => {
            // Flash message diciendo que todo bien
            document.getElementById(id).style.display = "none";
          })
          .catch((error) => {
            // Flash message diciendo que todo mal
          });
    },
    deleteUser(id) {
      if (confirm("This user and all its associated data will be deleted permanently."))
        deleteUserByID(id)
          .then((response) => {
            // Flash message diciendo que todo bien
            document.getElementById(id).style.display = "none";
          })
          .catch((error) => {
            // Flash message diciendo que todo mal
          });
    },
    moveTargetBackwards() {
      if (this.targetSelector - 1 < 0) {
        this.targetSelector = this.targets.length - 1;
      } else {
        this.targetSelector--;
      }
    },
    moveTargetForwards() {
      if (this.targetSelector + 1 >= this.targets.length) {
        this.targetSelector = 0;
      } else {
        this.targetSelector++;
      }
    },
    longToDate(time) {
      var date = new Date(parseInt(time));
      return date.toLocaleString();
    },
    decreasePageCounter() {
      if (this.page - 1 < 0) {
        this.page = Math.ceil(this.data[this.targets[this.targetSelector]].length / this.maxElements) - 1;
      } else {
        this.page--;
      }
      console.log("Abajro");
    },
    increasePageCounter() {
      if (this.page + 1 >= Math.ceil(this.data[this.targets[this.targetSelector]].length / this.maxElements)) {
        this.page = 0;
      } else {
        this.page++;
      }
      console.log("Arriba");
    },
    changePageOnScroll(event) {
      // Hacia arriba
      if (event.deltaY < 0) {
        this.increasePageCounter();
      } else {
        this.decreasePageCounter();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.page-display {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: row;
}

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
.select-container {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding-bottom: 1em;
  padding-top: 0.2em;
}

.title {
  width: 33vw;
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
      display: table-row;
      background-color: rgba(255, 255, 255, 0.1);
    }
  }
}
</style>
