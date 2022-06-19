import axios from "axios";

function view(input, types) {
  return axios.post("/api/data/country", {"input": input, "types": types});
}

function search(input) {
  return axios.get("/api/search/country/" + input);
}

export { view, search };
