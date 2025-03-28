import  api from './api';
export const getMembershipStats = (role) => api.get(`/${role}/membership-stats`);
export const getMembershipRequestsByStatus = (role, status) => api.get(`/${role}/membership-requests/${status}`);
export const getMembershipRequests = (role) => api.get(`/${role}/membership-requests`);
export const createRequest = (data) => api.post('/join-us', data);


