import axios from "axios";

function search(name) {
  return axios.get('https://restcountries.com/v3.1/name/' + name, {})
}

export {search};