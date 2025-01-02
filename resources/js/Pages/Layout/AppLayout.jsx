import React from 'react';
import PropTypes from 'prop-types';
import { Link } from '@inertiajs/inertia-react';

const AppLayout = ({ children }) => {
    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="bg-blue-600 p-4">
                <div className="container mx-auto">
                    <Link href="/dashboard" className="text-white mx-2">Dashboard</Link>
                    <Link href="/bookings" className="text-white mx-2">Bookings</Link>
                    <Link href="/logout" method="post" className="text-white mx-2">Logout</Link>
                </div>
            </nav>
            <main className="container mx-auto p-4">
                {children}
            </main>
        </div>
    );
};

AppLayout.propTypes = {
    children: PropTypes.node.isRequired,
};

export default AppLayout;
