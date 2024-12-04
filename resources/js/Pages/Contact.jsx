import React from 'react';
import { useForm } from '@inertiajs/inertia-react';

const Contact = ({ success }) => {
  const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    console.log("posting data", data);
    post('/contact', {
      onSuccess: () => {
        reset();
      }
    });
  };

  return (
    <section className="bg-gray-50 dark:bg-gray-900 py-16">
      <div className="max-w-2xl mx-auto px-6 lg:px-8">
        <h2 className="text-4xl font-extrabold text-center text-gray-900 dark:text-white mb-6">
          a4n8 exercise
        </h2>
        <p className="text-lg text-center text-gray-500 dark:text-gray-400 mb-12">
          Contact Form
        </p>

        {success && (
          <div
            className="fixed top-0 left-0 right-0 bg-green-500 text-white text-center py-3 px-6 z-50"
            role="alert"
          >
            <p className="text-lg font-semibold">{success}</p>
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label htmlFor="name" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Name
            </label>
            <input
              type="text"
              id="name"
              value={data.name}
              onChange={(e) => setData('name', e.target.value)}
              className="mt-2 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-primary-500"
              placeholder="Your Name"
              required
            />
            {errors.name && <p className="text-sm text-red-500 mt-1">{errors.name}</p>}
          </div>

          <div>
            <label htmlFor="email" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Email
            </label>
            <input
              type="email"
              id="email"
              value={data.email}
              onChange={(e) => setData('email', e.target.value)}
              className="mt-2 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-primary-500"
              placeholder="name@example.com"
              required
            />
            {errors.email && <p className="text-sm text-red-500 mt-1">{errors.email}</p>}
          </div>

          <div>
            <label htmlFor="phone" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Phone
            </label>
            <input
              type="tel"
              id="phone"
              value={data.phone}
              onChange={(e) => setData('phone', e.target.value)}
              className="mt-2 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-primary-500"
              placeholder="Your Phone Number"
              required
            />
            {errors.phone && <p className="text-sm text-red-500 mt-1">{errors.phone}</p>}
          </div>

          <div>
            <label htmlFor="message" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Message
            </label>
            <textarea
              id="message"
              rows="6"
              value={data.message}
              onChange={(e) => setData('message', e.target.value)}
              className="mt-2 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-primary-500"
              placeholder="Your Message"
              required
            />
            {errors.message && <p className="text-sm text-red-500 mt-1">{errors.message}</p>}
          </div>

          <div className="flex justify-center">
            <button
              disabled={processing}
              type="submit"
              className="w-full py-3 px-5 text-sm font-medium text-white rounded-lg bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300"
            >
              {processing ? 'Sending...' : 'Send Message'}
            </button>
          </div>
        </form>
      </div>
    </section>
  );
};

export default Contact;
