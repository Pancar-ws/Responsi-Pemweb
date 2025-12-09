const express = require('express');
const router = express.Router();
const adminController = require('../controllers/admin.controller');
const tourController = require('../controllers/tour.controller');
const { authMiddleware, adminMiddleware } = require('../middleware/auth.middleware');

// All admin routes require authentication and admin role
router.use(authMiddleware);
router.use(adminMiddleware);

// Dashboard statistics
router.get('/dashboard/stats', adminController.getDashboardStats);

// Manage bookings
router.get('/bookings', adminController.getAllBookings);
router.put('/bookings/:id', adminController.updateBookingStatus);

// Manage tours
router.get('/tours', tourController.getAllTours);
router.post('/tours', tourController.createTour);
router.put('/tours/:id', tourController.updateTour);
router.delete('/tours/:id', tourController.deleteTour);

// Manage users
router.get('/users', adminController.getAllUsers);

module.exports = router;
