import api from './api';

export const login = async (email, password) => {
    try {
        const response = await api.post('/login', { email, password });
        console.log('authService response:', response.data);
        return { user: response.data.user, token: response.data.token }; // Explicitly shape the return
    } catch (error) {
        console.log('authService error:', error.response || error);
        throw error;
    }
};

export const logout = async () => {
    try {
        await api.post('/logout'); // Call backend logout endpoint
    } catch (error) {
        console.error('Logout failed:', error.response?.data);
    }
    localStorage.removeItem('token');
    localStorage.removeItem('user');
};