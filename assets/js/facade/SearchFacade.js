import axios from "axios";

function search(input, types) {
  return axios.post("/api/data/country", {"input": input, "types": types});
}

export { search };
