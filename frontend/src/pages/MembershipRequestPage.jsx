import React, { useEffect, useState } from 'react';
import { useAuth } from '../context/AuthContext';
import { getMembershipRequests } from '../services/membershipService';
import toast from 'react-hot-toast';


const MembershipRequestPage = () => {
    const { user } = useAuth();
    const [requests, setRequests] = useState([]);
    const [filter, setFilter] = useState('pending');

    useEffect(() => {
        fetchRequests();
    }, [filter]);

    const fetchRequests = async () => {
        try {
            const response = await getMembershipRequests(user.role);
            const filteredRequests = response.data.filter((req) => req.status === filter);
            setRequests(filteredRequests);
        } catch (err) {
            toast.error('Failed to load membership requests.');
        }
    };

    const handleFilterChange = (status) => {
        setFilter(status);
    };

    if (!user) return <div>Loading...</div>;

    return (
        <div className="p-6">
            <h1 className="text-2xl font-bold mb-4">Membership Requests</h1>

            <div className="mb-6 flex space-x-2">
                <button
                    onClick={() => handleFilterChange('pending')}
                    className={`px-4 py-2 rounded-md ${
                        filter === 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                >
                    Pending ({requests.filter(r => r.status === 'pending').length})
                </button>
                <button
                    onClick={() => handleFilterChange('approved')}
                    className={`px-4 py-2 rounded-md ${
                        filter === 'approved' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                >
                    Approved
                </button>
                <button
                    onClick={() => handleFilterChange('rejected')}
                    className={`px-4 py-2 rounded-md ${
                        filter === 'rejected' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                >
                    Rejected
                </button>
                <button
                    onClick={() => handleFilterChange('blacklisted')}
                    className={`px-4 py-2 rounded-md ${
                        filter === 'blacklisted' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    }`}
                >
                    Blacklisted
                </button>
            </div>

            <div className="bg-white rounded-lg shadow overflow-x-auto">
                <table className="min-w-full">
                    <thead className="bg-gray-100">
                    <tr>
                        <th className="p-3 text-left">Name</th>
                        <th className="p-3 text-left">Email</th>
                        <th className="p-3 text-left">Role</th>
                        <th className="p-3 text-left">Status</th>
                        <th className="p-3 text-left">Requested At</th>
                        <th className="p-3 text-left">Reviewed At</th>
                        <th className="p-3 text-left">Reviewed By</th>
                    </tr>
                    </thead>
                    <tbody>
                    {requests.map((request) => (
                        <tr key={request.id} className="border-t">
                            <td className="p-3">{request.name}</td>
                            <td className="p-3">{request.email}</td>
                            <td className="p-3">{request.role}</td>
                            <td className="p-3">{request.status}</td>
                            <td className="p-3">
                                {request.requestedAt ? new Date(request.requestedAt).toLocaleDateString() : 'N/A'}
                            </td>
                            <td className="p-3">
                                {request.reviewedAt ? new Date(request.reviewedAt).toLocaleDateString() : 'N/A'}
                            </td>
                            <td className="p-3">
                                {request.reviewedBy ? request.reviewedBy.name : 'N/A'}
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
                {requests.length === 0 && (
                    <p className="p-4 text-center text-gray-500">No {filter} requests found.</p>
                )}
            </div>
        </div>
    );
};

export default MembershipRequestPage;