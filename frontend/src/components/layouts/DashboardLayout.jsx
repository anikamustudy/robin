import React, {useEffect, useState} from 'react';
import { Outlet, NavLink, useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import toast from 'react-hot-toast';


const DashboardLayout = () => {
    const { user, logout } = useAuth();
    const navigate = useNavigate();
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);

    useEffect(() => {
        if (!user) {
            navigate('/login');
        }
    }, [user, navigate]);

    const handleLogout = async () => {
        try {
            await logout(); // Ensure this is awaited
            toast.success('Logged out successfully!');
        } catch (err) {
            toast.error('Logout failed.');
        }
    };

    if (!user) return null;

    return (
        <div className="min-h-screen bg-gray-100 flex flex-col">
            {/* Navbar */}
            <nav className="bg-white shadow-md p-4 flex justify-between items-center">
                <div className="text-xl font-bold text-gray-800">Membership Dashboard</div>
                <div className="relative">
                    <button
                        onClick={() => setIsDropdownOpen(!isDropdownOpen)}
                        className="flex items-center space-x-2 focus:outline-none"
                    >
                        <div className="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold">
                            {user.name.charAt(0).toUpperCase()}
                        </div>
                        <span className="text-gray-700">{user.name}</span>
                        <svg
                            className="w-4 h-4 text-gray-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    {isDropdownOpen && (
                        <div className="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <div className="py-1">
                                <span className="block px-4 py-2 text-sm text-gray-700">Role: {user.role}</span>
                                <button
                                    onClick={handleLogout}
                                    className="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100"
                                >
                                    Logout
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </nav>

            {/* Main Content with Sidebar */}
            <div className="flex flex-1">
                {/* Sidebar */}
                <aside className=" w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white shadow-lg">
                    <div className="p-6">
                        <h2 className="text-2xl font-extrabold tracking-tight">Menu</h2>
                    </div>
                    <nav className="space-y-2">
                        <NavLink
                            to={user.role === 'admin' ? '/admin/dashboard' : `/bank/${user.bankName || 'dashboard'}`}
                            className={({ isActive }) =>
                                `flex items-center p-4 text-sm font-medium transition-colors duration-200 ${
                                    isActive ? 'bg-blue-600 text-white' : 'text-gray-200 hover:bg-gray-700 hover:text-white'
                                }`
                            }
                        >
                            <svg
                                className="w-5 h-5 mr-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                />
                            </svg>
                            Home
                        </NavLink>
                        <NavLink
                            to={user.role === 'admin' ? '/admin/membership-requests' : `/bank/${user.bankName || 'dashboard'}/membership-requests`}
                            className={({ isActive }) =>
                                `flex items-center p-4 text-sm font-medium transition-colors duration-200 ${
                                    isActive ? 'bg-blue-600 text-white' : 'text-gray-200 hover:bg-gray-700 hover:text-white'
                                }`
                            }
                        >
                            <svg
                                className="w-5 h-5 mr-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"
                                />
                            </svg>
                            Membership Requests
                        </NavLink>
                        {user.role === 'admin' && (
                            <NavLink
                                to="/admin/bank-types"
                                className={({ isActive }) =>
                                    `flex items-center p-4 text-sm font-medium transition-colors duration-200 ${
                                        isActive ? 'bg-blue-600 text-white' : 'text-gray-200 hover:bg-gray-700 hover:text-white'
                                    }`
                                }
                            >
                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-6 0H5" />
                                </svg>
                                Bank Types
                            </NavLink>
                        )}
                    </nav>
                </aside>

                {/* Main Content */}
                <main className="flex-1 p-6">
                    <Outlet />
                </main>
            </div>
        </div>
    );
};

export default DashboardLayout;