import axios from "axios";

function getAllCountries() {
  return axios.get("/api/country");
}

function getAllUsers() {
  return axios.get("/api/user");
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

function updateUseryById(id, data) {
  return axios.put("/api/user/" + id, data);
}

export { getAllCountries, 
         deleteCountryByID, 
         getAllUsers, 
         deleteUserByID, 
         updateCountryById, 
         updateUseryById };
