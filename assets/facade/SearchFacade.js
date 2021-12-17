import axios from "axios";

function search(input) {
  return axios.post('/data/country', {
      input
    })
}

export {search};