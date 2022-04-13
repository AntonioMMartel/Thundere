import axios from "axios";

function search(input) {
  return axios.post("/api/data/country", {
    input,
  });
}

export { search };
