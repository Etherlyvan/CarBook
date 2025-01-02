import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import PropTypes from 'prop-types'; // Mengimpor PropTypes
import AppLayout from '../Layout/AppLayout';

const Edit = ({ booking }) => {
    const [formData, setFormData] = useState({
        vehicle_id: booking.vehicle_id,
        requested_by: booking.requested_by,
        start_date: booking.start_date,
        end_date: booking.end_date,
        reason: booking.reason,
    });

    const [errors, setErrors] = useState({});

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        Inertia.put(`/bookings/${booking.id}`, formData, {
            onError: (errors) => {
                setErrors(errors);
            },
        });
    };

    return (
        <AppLayout>
            <h1 className="text-2xl font-bold">Edit Booking</h1>
            <form onSubmit={handleSubmit} className="mt-4">
                <div className="mb-4">
                    <label htmlFor="vehicle_id" className="block text-sm font-medium">Vehicle ID:</label>
                    <input
                        type="text"
                        name="vehicle_id"
                        id="vehicle_id"
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.vehicle_id}
                        onChange={handleChange}
                    />
                    {errors.vehicle_id && <div className="text-red-500">{errors.vehicle_id}</div>}
                </div>
                <div className="mb-4">
                    <label htmlFor="requested_by" className="block text-sm font-medium">Requested By:</label>
                    <input
                        type="text"
                        name="requested_by"
                        id="requested_by"
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.requested_by}
                        onChange={handleChange}
                    />
                    {errors.requested_by && <div className="text-red-500">{errors.requested_by}</div>}
                </div>
                <div className="mb-4">
                    <label htmlFor="start_date" className="block text-sm font-medium">Start Date:</label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.start_date}
                        onChange={handleChange}
                    />
                    {errors.start_date && <div className="text-red-500">{errors.start_date}</div>}
                </div>
                <div className="mb-4">
                    <label htmlFor="end_date" className="block text-sm font-medium">End Date:</label>
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.end_date}
                        onChange={handleChange}
                    />
                    {errors.end_date && <div className="text-red-500">{errors.end_date}</div>}
                </div>
                <div className="mb-4">
                    <label htmlFor="reason" className="block text-sm font-medium">Reason:</label>
                    <textarea
                        name="reason"
                        id="reason"
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.reason}
                        onChange={handleChange}
                    />
                    {errors.reason && <div className="text-red-500">{errors.reason}</div>}
                </div>
                <button type="submit" className="bg-blue-500 text-white px-4 py-2 rounded">
                    Update Booking
                </button>
            </form>
        </AppLayout>
    );
};

// Menambahkan validasi props
Edit.propTypes = {
    booking: PropTypes.shape({
        id: PropTypes.number.isRequired,
        vehicle_id: PropTypes.string.isRequired,
        requested_by: PropTypes.string.isRequired,
        start_date: PropTypes.string.isRequired,
        end_date: PropTypes.string.isRequired,
        reason: PropTypes.string.isRequired,
    }).isRequired,
};

export default Edit;
