import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';

const Login = () => {
    const [formData, setFormData] = useState({
        email: '',
        password: '',
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
        Inertia.post('/login', formData, {
            onError: (errors) => {
                setErrors(errors);
            },
        });
    };

    return (
        <div className="container mx-auto mt-10">
            <h1 className="text-2xl font-bold">Login</h1>
            <form onSubmit={handleSubmit} className="mt-4">
                <div className="mb-4">
                    <label htmlFor="email" className="block text-sm font-medium">Email:</label>
                    <input
                        type="email"
                        name="email"
                        id="email" // Menambahkan id untuk kontrol input
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.email}
                        onChange={handleChange}
                    />
                    {errors.email && <div className="text-red-500">{errors.email}</div>}
                </div>
                <div className="mb-4">
                    <label htmlFor="password" className="block text-sm font-medium">Password:</label>
                    <input
                        type="password"
                        name="password"
                        id="password" // Menambahkan id untuk kontrol input
                        className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        value={formData.password}
                        onChange={handleChange}
                    />
                    {errors.password && <div className="text-red-500">{errors.password}</div>}
                </div>
                <button type="submit" className="bg-blue-500 text-white px-4 py-2 rounded">
                    Login
                </button>
            </form>
        </div>
    );
};

export default Login;
