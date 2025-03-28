import React, { useEffect, useState, useRef } from 'react';
import { useAuth } from '../context/AuthContext';
import {
    getMembershipRequests,
    getMembershipStats } from '../services/membershipService.js';
import toast from 'react-hot-toast';

const DashboardPage = () => {
    const { user } = useAuth();
    const [stats, setStats] = useState({ pending: 0, approved: 0, rejected: 0, blacklisted: 0 });
    const [showTable, setShowTable] = useState(false);
    const [requests, setRequests] = useState([]);
    const [loading, setLoading] = useState(true);
    const hasToasted = useRef(false);

    useEffect(() => {
        const fetchStats = async () => {
            try {
                const response = await getMembershipStats(user.role);
                setStats(response.data);
                if (!hasToasted.current) {
                    toast.success('Welcome back to the dashboard!');
                    hasToasted.current = true;
                }
            } catch (err) {
                console.error(err);
                toast.error('Failed to load dashboard stats.');
            } finally {
                setLoading(false);
            }
        };
        fetchStats();
    }, [user.role]);

    const handleMoreClick = async () => {
        if (showTable) {
            setShowTable(false);
            setRequests([]);
        } else {
            setShowTable(true);
            try {
                const response = await getMembershipRequests(user.role);
                console.log('Fetched requests:', response.data); // Debug response
                setRequests(response.data);
            } catch (err) {
                console.error('Error fetching requests:', err.response || err); // Debug error
                toast.error('Failed to load requests.');
            }
        }
    };

    if (loading) return <p>Loading...</p>;

    return (
        <div>
            <h1 className="text-2xl font-bold mb-6">Dashboard</h1>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div className="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 className="text-lg font-semibold text-gray-700">Pending</h3>
                    <p className="text-3xl font-bold text-blue-600">{stats.pending}</p>
                    <button
                        onClick={handleMoreClick}
                        className="mt-4 text-sm text-blue-500 hover:underline"
                    >
                        More
                    </button>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 className="text-lg font-semibold text-gray-700">Approved</h3>
                    <p className="text-3xl font-bold text-green-600">{stats.approved}</p>
                    <button
                        onClick={handleMoreClick}
                        className="mt-4 text-sm text-blue-500 hover:underline"
                    >
                        More
                    </button>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 className="text-lg font-semibold text-gray-700">Rejected</h3>
                    <p className="text-3xl font-bold text-red-600">{stats.rejected}</p>
                    <button
                        onClick={handleMoreClick}
                        className="mt-4 text-sm text-blue-500 hover:underline"
                    >
                        More
                    </button>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 className="text-lg font-semibold text-gray-700">Blacklisted</h3>
                    <p className="text-3xl font-bold text-gray-600">{stats.blacklisted}</p>
                    <button
                        onClick={handleMoreClick}
                        className="mt-4 text-sm text-blue-500 hover:underline"
                    >
                        More
                    </button>
                </div>
            </div>

            {showTable && (
                <div className="mt-8 bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-xl font-semibold mb-4">All Membership Requests</h2>
                    <div className="overflow-x-auto">
                        <table className="min-w-full table-auto">
                            <thead className="bg-gray-100">
                            <tr>
                                <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                                <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
                                <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">Role</th>
                                <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                                <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">Requested At</th>
                            </tr>
                            </thead>
                            <tbody>
                            {requests.length > 0 ? (
                                requests.map((request) => (
                                    <tr key={request.id} className="border-t">
                                        <td className="px-4 py-2 text-sm text-gray-600">{request.email}</td>
                                        <td className="px-4 py-2 text-sm text-gray-600">{request.name}</td>
                                        <td className="px-4 py-2 text-sm text-gray-600">{request.role}</td>
                                        <td className="px-4 py-2 text-sm text-gray-600">{request.status}</td>
                                        <td className="px-4 py-2 text-sm text-gray-600">
                                            {request.requestedAt ? new Date(request.requestedAt).toLocaleDateString() : 'N/A'}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="5" className="px-4 py-2 text-center text-gray-500">
                                        No requests found.
                                    </td>
                                </tr>
                            )}
                            </tbody>
                        </table>
                    </div>
                </div>
            )}
        </div>
    );

};

export default DashboardPage;