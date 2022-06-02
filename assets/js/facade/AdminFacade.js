import axios from "axios";

function getAllCountries() {
  return axios.get("/api/admin/countries");
}

export { getAllCountries };
