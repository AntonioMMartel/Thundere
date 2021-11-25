import axios from "axios";

function register(email, name, password) {
  return axios.post('/register/user', {
      email,
      name,
      password
    })
}

function login(email, password) {
  const params = new URLSearchParams()
    params.append('email', email)
    params.append('password', password)
  return axios.post('/login', params,
  {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
}

export {register, login};