<template>
  <article>
    <div class="container-main">
      <FadingLightsAnimation />
      <div class="container-ui">
        <div class="select capitalize">Countries</div>
        <table>
          <thead>
            <tr>
              <th>Column 1</th>
              <th>Column 2</th>
              <th>Column 3</th>
              <th>Column 4</th>
              <th>Column 5</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cell 1</td>
              <td>Cell 2</td>
              <td>Cell 3</td>
              <td>Cell 4</td>
              <td>Cell 5</td>
            </tr>
            <tr>
              <td>Cell 1</td>
              <td>Cell 2</td>
              <td>Cell 3</td>
              <td>Cell 4</td>
              <td>Cell 5</td>
            </tr>
            <tr>
              <td>Cell 1</td>
              <td>Cell 2</td>
              <td>Cell 3</td>
              <td>Cell 4</td>
              <td>Cell 5</td>
            </tr>
            <tr>
              <td>Cell 1</td>
              <td>Cell 2</td>
              <td>Cell 3</td>
              <td>Cell 4</td>
              <td>Cell 5</td>
            </tr>
            <tr>
              <td>Cell 1</td>
              <td>Cell 2</td>
              <td>Cell 3</td>
              <td>Cell 4</td>
              <td>Cell 5</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </article>
</template>

<script>
import FadingLightsAnimation from "../components/FadingLightsAnimation.vue";
export default {
  name: "Admin",
  components: { FadingLightsAnimation },
};
</script>

<style lang="scss" scoped>
.select {
  font-size: 3rem;
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
