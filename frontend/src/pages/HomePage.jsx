import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createRequest } from '../services/membershipService'; // Import from membershipService
import toast from 'react-hot-toast';


const HomePage = () => {
    const navigate = useNavigate();
    const [showForm, setShowForm] = useState(false);
    const [role, setRole] = useState('');
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');

    const handleJoinUs = () => {
        setShowForm(true);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!role || !name || !email) {
            toast.error('Please fill all required fields.');
            return;
        }

        try {
            const response = await createRequest({ role, name, email });
            toast.success(response.data.message);
            setShowForm(false);
            setRole('');
            setName('');
            setEmail('');
        } catch (err) {
            toast.error(err.response?.data?.message || 'Failed to submit request.');
        }
    };

    return (
        <div className="min-h-screen bg-gray-100 flex flex-col justify-center items-center">
            <header className="w-full bg-white shadow-md p-4">
                <nav className="max-w-7xl mx-auto flex justify-between items-center">
                    <div className="text-xl font-bold text-gray-800">Membership Portal</div>
                    <div className="space-x-4">
                        <button
                            onClick={() => navigate('/login')}
                            className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        >
                            Login
                        </button>
                        <button
                            onClick={handleJoinUs}
                            className="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                        >
                            Join Us
                        </button>
                    </div>
                </nav>
            </header>

            <main className="flex-1 flex flex-col items-center justify-center text-center px-4">
                <h1 className="text-4xl font-bold text-gray-800 mb-4">Welcome to the Membership Portal</h1>
                <p className="text-lg text-gray-600 mb-8">
                    Connect with banks and valuers to streamline your membership process.
                </p>

                {showForm && (
                    <form onSubmit={handleSubmit} className="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                        <h2 className="text-2xl font-semibold mb-4">Join Us</h2>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Select Role</label>
                            <select
                                value={role}
                                onChange={(e) => setRole(e.target.value)}
                                className="w-full p-2 border rounded-md"
                                required
                            >
                                <option value="">-- Select Role --</option>
                                <option value="bank">Bank</option>
                                <option value="valuer">Valuer</option>
                            </select>
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                {role === 'bank' ? 'Bank Name' : role === 'valuer' ? 'Valuer Organization Name' : 'Name'}
                            </label>
                            <input
                                type="text"
                                value={name}
                                onChange={(e) => setName(e.target.value)}
                                className="w-full p-2 border rounded-md"
                                placeholder={`Enter ${role === 'bank' ? 'bank' : 'valuer'} name`}
                                required
                            />
                        </div>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input
                                type="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                className="w-full p-2 border rounded-md"
                                placeholder="Enter your email"
                                required
                            />
                        </div>
                        <button
                            type="submit"
                            className="w-full p-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                        >
                            Submit
                        </button>
                    </form>
                )}
            </main>
        </div>
    );
};

export default HomePage;