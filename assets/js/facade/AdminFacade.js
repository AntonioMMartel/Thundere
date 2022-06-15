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

function updateCountryById(id, data) {
  return axios.put("/api/country/" + id, data);
}

export { getAllCountries, deleteCountryByID, getAllUsers, deleteUserByID, updateCountryById };
