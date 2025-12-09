const express = require('express');
const router = express.Router();
const bookingController = require('../controllers/booking.controller');
const { authMiddleware } = require('../middleware/auth.middleware');
const upload = require('../middleware/upload.middleware');

// All booking routes require authentication
router.use(authMiddleware);

// User booking routes
router.post('/', upload.single('document'), bookingController.createBooking);
router.get('/', bookingController.getUserBookings);
router.get('/:id', bookingController.getBookingById);
router.put('/:id', bookingController.updateBookingStatus);
router.delete('/:id', bookingController.cancelBooking);

module.exports = router;
