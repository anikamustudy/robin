import React, { useState, useEffect } from 'react';
import { useAuth } from '../../context/AuthContext.jsx';
import {
    getBankTypes,
    createBankType,
    updateBankType,
    deleteBankType } from '../../services/bankTypeService.js';
import toast from 'react-hot-toast';

const BankTypePage = () => {
    const { user } = useAuth();
    const [bankTypes, setBankTypes] = useState([]);
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');
    const [editingId, setEditingId] = useState(null);

    useEffect(() => {
        fetchBankTypes();
    }, []);

    const fetchBankTypes = async () => {
        try {
            const response = await getBankTypes();
            setBankTypes(response.data);
        } catch (err) {
            toast.error('Failed to load bank types.');
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!name) {
            toast.error('Name is required.');
            return;
        }

        if (!description) {
            toast.error('Description is required.');
            return;
        }

        try {
            if (editingId) {
                await updateBankType(editingId, { name });
                toast.success('Bank type updated!');
            } else {
                await createBankType({ name,description });
                toast.success('Bank type created!');
            }
            setName('');
            setDescription('');
            setEditingId(null);
            fetchBankTypes();
        } catch (err) {
            toast.error(err.response?.data?.message || 'Failed to save bank type.');
        }
    };

    const handleEdit = (bankType) => {
        setName(bankType.name);
        setDescription(bankType.description);
        setEditingId(bankType.id);
    };

    const handleDelete = async (id) => {
        if (window.confirm('Are you sure?')) {
            try {
                await deleteBankType(id);
                toast.success('Bank type deleted!');
                fetchBankTypes();
            } catch (err) {
                toast.error('Failed to delete bank type.');
            }
        }
    };

    if (user.role !== 'admin') return <div>Unauthorized</div>;

    return (
        <div className="p-6 max-w-6xl mx-auto">
            <h1 className="text-2xl font-bold mb-6">Bank Types</h1>

            <form onSubmit={handleSubmit} className="mb-6 bg-white p-6 rounded-lg shadow w-full max-w-2xl mx-auto">
                <div className="mb-4">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Bank Type Name</label>
                    <input
                        type="text"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        className="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., Commercial Bank"
                        required
                    />
                </div>

                <div className="mb-4">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <input
                        type="text"
                        value={description}
                        onChange={(e) => setDescription(e.target.value)}
                        className="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., Short Description"
                        required
                    />
                </div>
                <button
                    type="submit"
                    className="w-full p-3 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors"
                >
                    {editingId ? 'Update' : 'Add'} Bank Type
                </button>
            </form>

            <div className="bg-white rounded-lg shadow overflow-x-auto">
                <table className="min-w-full">
                    <thead className="bg-gray-100">
                    <tr>
                        <th className="p-3 text-left">Name</th>
                        <th className="p-3 text-left">Created By</th>
                        <th className="p-3 text-left">Created At</th>
                        <th className="p-3 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {bankTypes.map((bankType) => (
                        <tr key={bankType.id} className="border-t">
                            <td className="p-3">{bankType.name}</td>
                            <td className="p-3">{bankType.creator?.name || 'Unknown'}</td>
                            <td className="p-3">{new Date(bankType.created_at).toLocaleDateString()}</td>
                            <td className="p-3 text-right">
                                <button
                                    onClick={() => handleEdit(bankType)}
                                    className="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 mr-2"
                                >
                                    Edit
                                </button>
                                <button
                                    onClick={() => handleDelete(bankType.id)}
                                    className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
                {bankTypes.length === 0 && <p className="p-4 text-center">No bank types found.</p>}
            </div>
        </div>
    );
};

export default BankTypePage;