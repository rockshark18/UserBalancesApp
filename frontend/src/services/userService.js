import axios from 'axios';
import {getToken} from "../util/cookies.js";

class UserService {
	// NOTE: Singleton паттерн
	constructor() {
		if (!UserService.instance) {
			this.apiUrl = import.meta.env.VITE_API_URL;
			UserService.instance = this;
		}
		return UserService.instance;
	}

	setAuthHeader() { // Устанавливаем заголовок авторизации
		const token = getToken();
		if (token) {
			axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
		} else {
			delete axios.defaults.headers.common['Authorization'];
		}
	}

	async login(email, password) {
		try {
			const response = await axios.post(
				`${this.apiUrl}/login`,
				{
					email: email,
					password: password,
				});
			return response;
		} catch (error) {
			if (error.response && error.response.data && error.response.data.error) {
				throw error.response.data.error;
			}
			throw error; // unknown error
		}

	}
	async getUser() {
		this.setAuthHeader();
		try {
			const response = await axios.get(
				`${this.apiUrl}/user`);
			return response
		} catch (error) {
			if (error.response && error.response.data && error.response.data.error) {
				throw error.response.data.error;
			}
			throw error; // unknown error
		}
	}

	async logout() {
		this.setAuthHeader();
		try {
			const response = await axios.post(
				`${this.apiUrl}/logout`);
			return response
		} catch (error) {
			if (error.response && error.response.data && error.response.data.error) {
				throw error.response.data.error;
			}
			throw error; // unknown error
		}
	}

}

const instance = new UserService();
Object.freeze(instance);

export default instance;
