<template>
  <div class="container-main">
    <UpdateDialog 
      v-if="dialogIsOpen" 
      @closeDialog="closeDialog" 
      :dialogIsUpdating="dialogIsUpdating" 
      :target="targets[targetSelector]" 
      :data="openDialogData" 
      :id="selectedId"
      :message="dialogMessage"
      :mode="dialogModes[selectedDialogMode]" />
    <FadingLightsAnimation />
    <div class="container-ui">
      <div class="select-container">
        <img data-test="moveTargetBackwards" v-on:click="moveTargetBackwards()" class="arrow button" src="../../../svgs/ArrowLeft.svg" />
        <div data-test="selectedTarget" class="select capitalize title">{{ targets[targetSelector] }}</div>
        <img data-test="moveTargetForwards" v-on:click="moveTargetForwards()" class="arrow button" src="../../../svgs/ArrowRight.svg" />
      </div>

      <table data-test="countriesTable" v-if="targets[targetSelector] == 'Countries'">
        <thead>
          <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Data</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr data-test="dataRow" v-for="country in data['Countries'].slice(page * 5, (page + 1) * 5)" :key="country._id.$oid" v-bind:id="country._id.$oid">
            <td>{{ country.isoCode }}</td>
            <td><DynamicArrayViewer :array="country.names"></DynamicArrayViewer></td>
            <td class="button">Go to</td>
            <td class="unselectable">
              <div class="icons">
                <img
                  data-test="updateButton"
                  v-on:click="
                    openDialog({
                      'Iso code': country.isoCode,
                      Names: country.names,
                    },
                    country._id.$oid,
                    true)
                  "
                  class="unselectable button"
                  src="../../../svgs/EditButton.svg"
                />
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

      <table data-test="usersTable" v-if="targets[targetSelector] == 'Users'">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th> Password</th>
            <th>Roles</th>
            <th>Confirmation Time</th>
            <th>Created Time</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr data-test="dataRow" v-for="user in data['Users'].slice(page * 5, (page + 1) * 5)" :key="user._id.$oid" v-bind:id="user._id.$oid">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.password }}</td>
            <td><DynamicArrayViewer :array="user.roles"></DynamicArrayViewer></td>
            <td>{{ longToDate(user.confirmation_time.$date.$numberLong) }}</td>
            <td>{{ longToDate(user.created_time.$date.$numberLong) }}</td>
            <td class="unselectable">
              <div class="icons">
                <img
                  v-on:click="
                    openDialog({
                      Name: user.name,
                      Email: user.email,
                      Password: '',
                      Roles: user.roles,
                      'Confirmation time': longToDate(user.confirmation_time.$date.$numberLong),
                      'Creation time': longToDate(user.created_time.$date.$numberLong),
                    },
                    user._id.$oid,
                    true)
                  "
                  class="unselectable button"
                  src="../../../svgs/EditButton.svg"
                />
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

      <img data-test="addButton" v-on:click="openDialog({}, 0, false)" class="add button" src="../../../svgs/add.svg" />
        <div class="select-container"> 
          <img v-on:click="moveDialogModeBackwards()" class="arrow button" src="../../../svgs/ArrowLeft.svg" />
          <div class="sub-title">{{ dialogModes[selectedDialogMode] }} </div>
          <img v-on:click="moveDialogModeForwards()" class="arrow button" src="../../../svgs/ArrowRight.svg" />
        </div>

      
      
    </div>
  </div>
</template>

<script>
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import DynamicArrayViewer from "../components/DynamicArrayViewer.vue";
import UpdateDialog from "../components/UpdateDialog.vue";
import { getAllCountries, deleteCountryByID, getAllUsers, deleteUserByID,addAllCountries } from "../../facade/AdminFacade.js";
export default {
  name: "Admin",
  components: { FadingLightsAnimation, DynamicArrayViewer, UpdateDialog },
  data() {
    return {
      data: { Countries: [], Users: [] },
      message: "Loading data...",
      targets: ["Countries", "Users"],
      targetSelector: 0,
      page: 0,
      maxElements: 5,
      openDialogData: {},
      dialogIsOpen: false,
      selectedId: 0,
      dialogIsUpdating: false,
      dialogMessage: "",
      dialogModes: ["Add one normally", "Add one using api", "Add all using api"],
      selectedDialogMode: 0
    };
  },
  beforeMount() {
    // Pilla todos los datos
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
    // Los cacheas
    // // // //
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
    },
    increasePageCounter() {
      if (this.page + 1 >= Math.ceil(this.data[this.targets[this.targetSelector]].length / this.maxElements)) {
        this.page = 0;
      } else {
        this.page++;
      }
    },
    changePageOnScroll(event) {
      // Hacia arriba
      if (event.deltaY < 0) {
        this.increasePageCounter();
      } else {
        this.decreasePageCounter();
      }
    },
    openDialog(data, id, dialogIsUpdating) {

      
      if(dialogIsUpdating){ // Update
        this.dialogIsUpdating = true
        this.openDialogData = data;
        this.selectedId = id;
        this.dialogIsOpen = true;

      } else { // Add
        this.dialogIsUpdating = false
        if(this.targets[this.targetSelector] === "Users"){ // User
          this.openDialogData = {
                                  Name: '',
                                  Email:'',
                                  Password: '',
                                  Roles: [],
                                  'Confirmation time': this.longToDate(Date.now()),
                                  'Creation time': this.longToDate(Date.now()),
                                }
          this.dialogIsOpen = true;

        } else if (this.targets[this.targetSelector] === "Countries"){ //Country

          if(this.dialogModes[this.selectedDialogMode] === "Add one using api") {
            this.openDialogData = {'Name': "", }
            this.dialogMessage = "Put the name of the country you want to add and well call our apis to have it completed automatically for you :)"
            this.dialogIsOpen = true;

          } else if (this.dialogModes[this.selectedDialogMode] === "Add all using api") {
            addAllCountries({"Mode": "ADD_ALL"});

          } else if (this.dialogModes[this.selectedDialogMode] === "Add one normally") { // Solamente va a añadir
            this.openDialogData = {
                                    'Iso Code': "",
                                    'Names': []
                                  }
            this.dialogMessage = "Be sure to include something in names so you can search it and modify it via the country viewer"
            this.dialogIsOpen = true;

          }
         
        }
      }
      
    },
    closeDialog() {
      this.dialogIsOpen = false;
      this.dialogMessage = '';
    },
    moveDialogModeBackwards() {
      if (this.selectedDialogMode - 1 < 0) {
        this.selectedDialogMode = this.dialogModes.length - 1;
      } else {
        this.selectedDialogMode--;
      }
    },
    moveDialogModeForwards() {
      if (this.selectedDialogMode + 1 >= this.dialogModes.length) {
        this.selectedDialogMode = 0;
      } else {
        this.selectedDialogMode++;
      }
    },
  },
};
</script>

<style lang="scss" scoped>

.sub-title {
  font-size: 1.5em;
  text-align: center;
  width: 100px;
  margin-top: 0.5em;

}

.add {
  margin-top: 1.5em;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  border-radius: 100px;
  background-color: rgba(255, 255, 255, 0.1);
  &:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }
  
}

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
  max-width: 20vw;
  word-wrap: break-word;

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
