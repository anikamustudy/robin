import  api from "./api";

export const getBankTypes = () => api.get('/admin/bank-types');
export const createBankType = (data) => api.post('/admin/bank-types', data);
export const updateBankType = (id, data) => api.put(`/admin/bank-types/${id}`, data);
export const deleteBankType = (id) => api.delete(`/admin/bank-types/${id}`);