import axios from "axios";

function register(email, name, password) {
  return axios.post('/user/create', {
      email,
      name,
      password
    })
}

function login(email, password) {
  return axios.post('/user/login', {
    auth: {
      email,
      password
    }
  })
}

export default [register, login];