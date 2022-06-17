import axios from "axios";

function register(email, name, password) {
  return axios.post("/api/user", {
    email,
    name,
    password,
  });
}

function login(email, password, _csrf_token) {
  const params = new URLSearchParams();
  params.append("email", email);
  params.append("password", password);
  params.append("csrf_token", _csrf_token);
  return axios.post("/login", params, { headers: { "Content-Type": "application/x-www-form-urlencoded" } });
}

export { register, login };
