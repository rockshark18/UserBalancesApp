import Cookies from 'js-cookie';
import router from "@/router/router";

export const setToken = (token) => {
	Cookies.set('access_token', token, { expires: 7, secure: true, sameSite: 'Strict' });
};

export const getToken = () => {
	return Cookies.get('access_token');
};

export const removeToken = () => {
	Cookies.remove('access_token');
	router.push('/login');
};
