import axios from "axios";

function search(input) {
  return axios.post('/api/data/search', {
      input
    })
}

export {search};