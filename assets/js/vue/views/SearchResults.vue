<template>
  <div v-on:wheel="changePageOnScroll($event)" class="container-main">
    <FadingLightsAnimation />
    <div class="container-ui">
      <CountrySearchInput :inputValue="input" :to="'/search'" />
      <div class="country-view">    
        <img v-if="Object.keys(this.data).length > 6" v-on:click="decreasePageCounter()" class="page-arrow left-arrow button" src="../../../svgs/ArrowLeft.svg" />
        <div class="grid">
            <div v-for="(country, key) in  Object.entries(data).slice(page * 6, (page + 1) * 6)" 
            :key="key" :id="key">
              <div v-on:click="viewCountry(country[0])" class="country-container button">
                <img class="flag" :src="country[1]" :alt="country[0] + 'flag'">
                <div class="divider">
                  <div class=" country-title">
                    {{ country[0] }}
                  </div>
                </div>
              </div>
            </div>
        </div>
        <img v-if="Object.keys(this.data).length > 6" v-on:click="increasePageCounter()" class="page-arrow right-arrow button" src="../../../svgs/ArrowRight.svg" />
      </div>
      <div v-if="Object.keys(this.data).length > 6" class="page-display">
        {{ page + 1 }}
      </div>
    </div>

  </div>

</template>

<script>
import CountrySearchInput from "../components/CountrySearchInput.vue";
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
import { search, view } from "../../facade/SearchFacade";

export default {
  name: "SearchResults",
  components: { FadingLightsAnimation, CountrySearchInput },
  props: ["input"],
  data() {
    return {
      data: [],
      page: 0
    }
  },
  methods: {
    decreasePageCounter() {
      if (this.page - 1 < 0) {
        console.log(Object.keys(this.data).length)
        this.page = Math.ceil(Object.keys(this.data).length / 6) - 1;
      } else {
        this.page--;
      }
    },
    increasePageCounter() {
      if (this.page + 1 >= Math.ceil(Object.keys(this.data).length / 6)) {
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
    viewCountry(input) {
      window.location.replace("/country/" + input);
    }
  },
  beforeMount() {
    search(this.input)
    .then((response) => {
      this.data = response.data
    })
    .catch( (error) => {
      console.log(error)
    })
  },

};
</script>

<style lang="scss" scoped>

.left-arrow {
  margin-right: 5em;
}

.right-arrow {
  margin-left: 5em;
}
.country-view {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
}


.country-title {
  text-align: center;
  padding: 1.5em;
  font-size: 1.4rem;
}

.country-container {
  width: 300px; 
  height: 300px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  border-radius: 20px;
  display: flex;
  flex-direction: column;
  background-color: rgba(255, 255, 255, 0.1);
}

.grid {
  margin: 2em;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 20px;
  width: 90%;
  justify-content: center;
  justify-items: center;
}

.container-main {
  display: flex;
  height: 80vh;
  flex-wrap: wrap;
  color: $primary-color;
  padding: 1em;
}

.container-ui {
  width: 100%;
  height: 80vh;
  display: flex;
  flex-direction: column;
  align-items: center;

}

.flag {
  width: 300px;
  min-width: 300px;
  height: 200px;
  min-height: 200px;
  border-radius: 20px 20px 0 0;
}

.divider{
  overflow:hidden;
  position:relative;
}

.divider::before{ 
  content:'';
  position: absolute;
  z-index: 3;
  pointer-events: none;
  background-repeat: no-repeat;
  bottom: -0.1vh;
  left: -0.1vw;
  right: -0.1vw;
  top: -0.1vw; 
  height: 100px;
  transform: rotate(180deg);
  background-size: 100% 80px;
  background-position: 50% 100%;  background-image: url('data:image/svg+xml;charset=utf8, <svg preserveAspectRatio="xMidYMin slice" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2001 77"><g fill="%23ffffff"><path opacity=".1" d="M1993 31v22l-19 11-19-11V31l19-11 19 11zM1942 6v11l-10 5-10-5V6l10-6 10 6z"/><path opacity=".15" d="M1961 25v16l-14 8-14-8V25l14-8 14 8zM1969 8v8l-7 4-6-4V8l6-4 7 4z"/><path opacity=".1" d="M1871 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M1903 25v16l14 8 14-8V25l-14-8-14 8zM1895 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M1855 31v22l-19 11-19-11V31l19-11 19 11zM1803 6v11l-9 5-10-5V6l10-6 9 6z"/><path opacity=".15" d="M1823 25v16l-14 8-14-8V25l14-8 14 8zM1831 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M1733 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M1765 25v16l14 8 14-8V25l-14-8-14 8zM1757 8v8l6 4 7-4V8l-7-4-6 4z"/><path opacity=".1" d="M1717 31v22l-19 11-19-11V31l19-11 19 11zM1665 6v11l-9 5-10-5V6l10-6 9 6z"/><path opacity=".15" d="M1685 25v16l-14 8-14-8V25l14-8 14 8zM1693 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M1594 31v22l19 11 20-11V31l-20-11-19 11z"/><path opacity=".15" d="M1626 25v16l14 8 15-8V25l-15-8-14 8zM1618 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M1579 31v22l-19 11-20-11V31l20-11 19 11zM1527 6v11l-10 5-9-5V6l9-6 10 6z"/><path opacity=".15" d="M1547 25v16l-14 8-15-8V25l15-8 14 8zM1555 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M1456 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M1488 25v16l14 8 14-8V25l-14-8-14 8zM1480 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M1441 31v22l-20 11-19-11V31l19-11 20 11zM1389 6v11l-10 5-9-5V6l9-6 10 6z"/><path opacity=".15" d="M1408 25v16l-14 8-14-8V25l14-8 14 8zM1416 8v8l-6 4-7-4V8l7-4 6 4z"/><path opacity=".1" d="M1318 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M1350 25v16l14 8 14-8V25l-14-8-14 8zM1342 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M1302 31v22l-19 11-19-11V31l19-11 19 11zM1251 6v11l-10 5-10-5V6l10-6 10 6z"/><path opacity=".15" d="M1270 25v16l-14 8-14-8V25l14-8 14 8zM1278 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M1180 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M1212 25v16l14 8 14-8V25l-14-8-14 8zM1204 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M1164 31v22l-19 11-19-11V31l19-11 19 11zM1112 6v11l-9 5-10-5V6l10-6 9 6z"/><path opacity=".15" d="M1132 25v16l-14 8-14-8V25l14-8 14 8zM1140 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M1041 31v22l20 11 19-11V31l-19-11-20 11z"/><path opacity=".15" d="M1074 25v16l14 8 14-8V25l-14-8-14 8zM1066 8v8l6 4 7-4V8l-7-4-6 4z"/><path opacity=".1" d="M1026 31v22l-19 11-20-11V31l20-11 19 11zM974 6v11l-9 5-10-5V6l10-6 9 6z"/><path opacity=".15" d="M994 25v16l-14 8-14-8V25l14-8 14 8zM1002 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M903 31v22l19 11 20-11V31l-20-11-19 11z"/><path opacity=".15" d="M935 25v16l14 8 15-8V25l-15-8-14 8zM927 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M888 31v22l-20 11-19-11V31l19-11 20 11zM836 6v11l-10 5-9-5V6l9-6 10 6z"/><path opacity=".15" d="M856 25v16l-15 8-14-8V25l14-8 15 8zM864 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M765 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M797 25v16l14 8 14-8V25l-14-8-14 8zM789 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M749 31v22l-19 11-19-11V31l19-11 19 11zM698 6v11l-10 5-9-5V6l9-6 10 6z"/><path opacity=".15" d="M717 25v16l-14 8-14-8V25l14-8 14 8zM725 8v8l-7 4-6-4V8l6-4 7 4z"/><path opacity=".1" d="M627 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M659 25v16l14 8 14-8V25l-14-8-14 8zM651 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M611 31v22l-19 11-19-11V31l19-11 19 11zM560 6v11l-10 5-10-5V6l10-6 10 6z"/><path opacity=".15" d="M579 25v16l-14 8-14-8V25l14-8 14 8zM587 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M489 31v22l19 11 19-11V31l-19-11-19 11z"/><path opacity=".15" d="M521 25v16l14 8 14-8V25l-14-8-14 8zM513 8v8l7 4 6-4V8l-6-4-7 4z"/><path opacity=".1" d="M473 31v22l-19 11-19-11V31l19-11 19 11zM421 6v11l-9 5-10-5V6l10-6 9 6z"/><path opacity=".15" d="M441 25v16l-14 8-14-8V25l14-8 14 8zM449 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M350 31v22l20 11 19-11V31l-19-11-20 11z"/><path opacity=".15" d="M382 25v16l15 8 14-8V25l-14-8-15 8zM374 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M335 31v22l-19 11-20-11V31l20-11 19 11zM283 6v11l-10 5-9-5V6l9-6 10 6z"/><path opacity=".15" d="M303 25v16l-14 8-14-8V25l14-8 14 8zM311 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M212 31v22l19 11 20-11V31l-20-11-19 11z"/><path opacity=".15" d="M244 25v16l14 8 14-8V25l-14-8-14 8zM236 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M197 31v22l-20 11-19-11V31l19-11 20 11zM145 6v11l-10 5-9-5V6l9-6 10 6z"/><path opacity=".15" d="M164 25v16l-14 8-14-8V25l14-8 14 8zM173 8v8l-7 4-7-4V8l7-4 7 4z"/><path opacity=".1" d="M74 31v22l19 11 19-11V31L93 20 74 31z"/><path opacity=".3" d="M53 9v15l13 7 13-7V9L66 1 53 9zM191 9v15l13 7 13-7V9l-13-8-13 8zM330 9v15l13 7 13-7V9l-13-8-13 8zM468 9v15l13 7 13-7V9l-13-8-13 8zM606 9v15l13 7 13-7V9l-13-8-13 8zM744 9v15l13 7 13-7V9l-13-8-13 8zM883 9v15l12 7 13-7V9l-13-8-12 8zM1021 9v15l13 7 13-7V9l-13-8-13 8zM1159 9v15l13 7 13-7V9l-13-8-13 8zM1297 9v15l13 7 13-7V9l-13-8-13 8zM1435 9v15l13 7 13-7V9l-13-8-13 8zM1574 9v15l13 7 12-7V9l-12-8-13 8zM1712 9v15l13 7 13-7V9l-13-8-13 8zM1850 9v15l13 7 13-7V9l-13-8-13 8z"/><path opacity=".15" d="M106 25v16l14 8 14-8V25l-14-8-14 8zM98 8v8l7 4 7-4V8l-7-4-7 4z"/><path opacity=".1" d="M58 31v22L39 64 20 53V31l19-11 19 11z"/><path opacity=".15" d="M34 8v8l-7 4-6-4V8l6-4 7 4z"/><path opacity="0.15" d="M2001 77V62l-21-12-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14L0 64v13h2001z"/><path opacity=".15" d="M12 49L0 42V23l12-6 14 8v16l-14 8z"/><path opacity=".3" d="M2001 31l-13-7V9l13-8v30z"/></g></svg>'); 

}

.inverted {
  transform: rotate(180deg);
}

@media (min-width:2100px){
  .divider::before{
    background-size: 100% calc(2vw + 66px);
  }
}

.page-display {
  font-size: 1.75rem;
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
  height: 10%;
}
</style>
