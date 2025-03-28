import {BrowserRouter as Router, Route, Routes} from 'react-router-dom';
import {AuthProvider} from "./context/AuthContext.jsx";
import GuestLayout from "./components/layouts/GuestLayout.jsx";
import DashboardLayout from "./components/layouts/DashboardLayout.jsx";
import LoginPage from "./pages/auth/LoginPage.jsx";
import MembershipRequestPage from "./pages/MembershipRequestPage.jsx";
import DashboardPage from "./pages/DashboardPage.jsx";
import HomePage from "./pages/HomePage.jsx";
import BankTypePage from "./pages/admin/BankTypePage.jsx";
import { Toaster } from 'react-hot-toast';

//enika ji, pls look at this file and we need to discuss



const App = () => {
    return (
        <Router>
            <AuthProvider>
                <Routes>
                    <Route element={<GuestLayout/>}>
                        <Route path="/" element={<HomePage />} />
                        <Route path="/login" element={<LoginPage/>}/>
                    </Route>
                    <Route element={<DashboardLayout/>}>
                        <Route path="/admin/dashboard" element={<DashboardPage />} />
                        <Route path="/admin/bank-types" element={<BankTypePage />} />
                        <Route path="/admin/membership-requests" element={<MembershipRequestPage />} />
                        <Route path="/bank/:bankName" element={<DashboardPage />} />
                        <Route path="/bank/:bankName/membership-requests" element={<MembershipRequestPage />} />
                    </Route>
                </Routes>
                <Toaster position="top-right" reverseOrder={false} />
            </AuthProvider>
        </Router>
    );
};

export default App;