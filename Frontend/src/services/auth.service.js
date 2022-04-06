import axios from 'axios';

const AUTH_LOGIN_ENDPOINT = 'api/auth/login/';
const AUTH_LOGOUT_ENDPOINT = 'api/auth/logout/';
const AUTH_PING = 'api/auth/ping/';

class AuthService {
  login(user) {
    return axios
      .post(AUTH_LOGIN_ENDPOINT, {
        email: user.email,
        password: user.password
      });
  }

  async logout(token) {
    await axios.post(
      AUTH_LOGOUT_ENDPOINT,
      {},
      {
        headers: {
          Authorization: 'Bearer ' + `${token}`,
        },
      },
    );
  }

  ping(token) {
    return axios.post(
      AUTH_PING,
      {},
      {
        headers: {
          Authorization: 'Bearer ' + `${token}`,
        },
      },
    );
  }
}

export default new AuthService();
