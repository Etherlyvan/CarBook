import React from 'react';
import { Inertia } from '@inertiajs/inertia';
import PropTypes from 'prop-types'; // Mengimpor PropTypes
import AppLayout from '../Layout/AppLayout';

const Index = ({ bookings }) => {
    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this booking?')) {
            Inertia.delete(`/bookings/${id}`);
        }
    };

    return (
        <AppLayout>
            <h1 className="text-2xl font-bold">Bookings</h1>
            <div className="mt-4">
                <button
                    onClick={() => Inertia.visit('/bookings/create')}
                    className="bg-green-500 text-white px-4 py-2 rounded mb-4"
                >
                    Create Booking
                </button>
                <table className="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th className="border border-gray-300 px-4 py-2">ID</th>
                            <th className="border border-gray-300 px-4 py-2">Vehicle</th>
                            <th className="border border-gray-300 px-4 py-2">Requested By</th>
                            <th className="border border-gray-300 px-4 py-2">Status</th>
                            <th className="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {bookings.map((booking) => (
                            <tr key={booking.id}>
                                <td className="border border-gray-300 px-4 py-2">{booking.id}</td>
                                <td className="border border-gray-300 px-4 py-2">{booking.vehicle.name}</td>
                                <td className="border border-gray-300 px-4 py-2">{booking.requester.name}</td>
                                <td className="border border-gray-300 px-4 py-2">{booking.status}</td>
                                <td className="border border-gray-300 px-4 py-2">
                                    <button onClick={() => handleDelete(booking.id)} className="text-red-500">
                                        Delete
                                    </button>
                                    <button onClick={() => Inertia.visit(`/bookings/${booking.id}/edit`)} className="text-blue-500 ml-2">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AppLayout>
    );
};

// Menambahkan validasi props
Index.propTypes = {
    bookings: PropTypes.arrayOf(
        PropTypes.shape({
            id: PropTypes.number.isRequired,
            vehicle: PropTypes.shape({
                name: PropTypes.string.isRequired,
            }).isRequired,
            requester: PropTypes.shape({
                name: PropTypes.string.isRequired,
            }).isRequired,
            status: PropTypes.string.isRequired,
        })
    ).isRequired,
};

export default Index;
