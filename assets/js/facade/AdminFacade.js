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

function addCountry(data) {
  return axios.post("/api/country", data)
}

function addUser(data) {
  for (const label in data) {
      data[label.toLowerCase().replaceAll(' ', '_')] = data[label]
      delete data[label]
  }
  return axios.post("/api/user", data)
}

export { getAllCountries, 
         deleteCountryByID, 
         getAllUsers, 
         deleteUserByID, 
         updateCountryById, 
         updateUseryById,
         addCountry,
         addUser
         };
