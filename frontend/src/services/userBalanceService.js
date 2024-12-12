import axios from 'axios';
import {getToken} from "../util/cookies.js";

class UserBalanceService {
	// NOTE: Я использую Singleton паттерн
	constructor() {
		if (!UserBalanceService.instance) {
			this.apiUrl = import.meta.env.VITE_API_URL+'/v1';
			UserBalanceService.instance = this;
		}
		return UserBalanceService.instance;
	}

	setAuthHeader() { // Устанавливаем заголовок авторизации
		const token = getToken();
		if (token) {
			axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
		} else {
			delete axios.defaults.headers.common['Authorization'];
		}
	}

	async getBalance() {
		this.setAuthHeader();
		try {
			let url =`${this.apiUrl}/userbalance`;
			let response;
			response = await axios.get(url);
			return response.data.data.userbalance;
		} catch (error) {
			if (error.response && error.response.data && error.response.data.error) {
				throw error.response.data.error;
			}
			throw error; // unknown error
		}
	}
}

const instance = new UserBalanceService();
Object.freeze(instance);

export default instance;
