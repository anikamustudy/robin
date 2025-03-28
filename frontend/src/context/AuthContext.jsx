import React, { createContext, useState, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import { login as authLogin, logout as authLogout } from '../services/authService';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const storedUser = localStorage.getItem('user');
    const storedToken = localStorage.getItem('token');

    let initialUser = null;
    if (storedUser) {
        try {
            initialUser = JSON.parse(storedUser);
        } catch (e) {
            console.error('Failed to parse stored user from localStorage:', e);
            localStorage.removeItem('user');
        }
    }

    const [user, setUser] = useState(initialUser);
    const [token, setToken] = useState(storedToken || null);
    const navigate = useNavigate();

    const login = async (email, password) => {
        try {
            const response = await authLogin(email, password); // Get raw response
            const { user, token } = response; // Destructure here
            setUser(user);
            setToken(token);
            localStorage.setItem('token', token);
            localStorage.setItem('user', JSON.stringify(user));

            if (user.role === 'admin') {
                navigate('/admin/dashboard');
            } else if (user.role === 'bank') {
                const response = await api.get('/bank/profile');
                const bankName = response.data.name.toLowerCase().replace(/\s+/g, '-');
                user.bankName = bankName;
                localStorage.setItem('user', JSON.stringify(user));
                navigate(`/bank/${bankName}`);
            } else if (user.role === 'valuer') {
                const response = await api.get('/valuer/profile');
                const orgName = response.data.org_name.toLowerCase().replace(/\s+/g, '-');
                user.orgName = orgName;
                localStorage.setItem('user', JSON.stringify(user));
                navigate(`/valuer/${orgName}`);
            }
        } catch (error) {
            console.log('AuthContext login error:', error);
            throw error;
        }
    };

    const logout = async () => {
        await authLogout();
        setUser(null);
        setToken(null);
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        navigate('/login', { replace: true });
    };


    return (
        <AuthContext.Provider value={{ user, token, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => useContext(AuthContext);