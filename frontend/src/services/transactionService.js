import axios from 'axios';
import {getToken} from "../util/cookies.js";

class TransactionService {
	// NOTE: Я использую Singleton паттерн
	constructor() {
		if (!TransactionService.instance) {
			this.apiUrl = import.meta.env.VITE_API_URL+'/v1';
			TransactionService.instance = this;
		}
		return TransactionService.instance;
	}

	setAuthHeader() { // Устанавливаем заголовок авторизации
		const token = getToken();
		if (token) {
			axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
		} else {
			delete axios.defaults.headers.common['Authorization'];
		}
	}

	async get(search, limit) {
		this.setAuthHeader();
		try {
			let url =`${this.apiUrl}/transactions`;
			let response;
			if (search!==null) {
				response = await axios.post(url, {limit: limit, search: search});
			}else{
				response = await axios.post(url,{limit: limit});
			}
			return response.data.data.transactions;
		} catch (error) {
			if (error.response && error.response.data && error.response.data.error) {
				throw error.response.data.error;
			}
			throw error; // unknown error
		}
	}
}

const instance = new TransactionService();
Object.freeze(instance);

export default instance;
