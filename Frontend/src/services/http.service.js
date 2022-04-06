import axios from 'axios';

class HttpService {

  async get(url, config = {}) {
    const response = await axios.get(url, this._configAddAuth(config));

    return response;
  }

  async post(url, model, config = {}) {
    const response = await axios.post(url, model, this._configAddAuth(config));

    return response;
  }

  async put(url, model = undefined) {
    const response = await axios.put(url, model, this._configAddAuth({}));
    return { data: response };
  }

  async delete(url) {
    const response = await axios.delete(url, this._configAddAuth({}));
    return response;
  }

  _configAddAuth(config) {
    const token = localStorage.getItem('token');
    return {
      ...{},
      ...config,
      ...{
        headers: {
          Authorization: `Bearer ${token}`,
        },
      },
    };
  }
}

export default new HttpService();