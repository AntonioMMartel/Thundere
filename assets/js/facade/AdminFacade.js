import axios from "axios";

function getAllCountries() {
  return axios.get("/api/admin/countries");
}

function getAllUsers() {
  return axios.get("/api/admin/users");
}

function deleteCountryByID(id) {
  return axios.delete("/api/country/" + id);
}

function deleteUserByID(id) {
  return axios.delete("/api/user/" + id);
}

export { getAllCountries, deleteCountryByID, getAllUsers, deleteUserByID };
