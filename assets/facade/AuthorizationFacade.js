import axios from "axios";

export default function register(email, name, password) {

    return axios.post('/user/register', {
        email,
        name,
        password
      })


}

function login(email, password) {

}
