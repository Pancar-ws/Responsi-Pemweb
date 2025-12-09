const db = require('../config/database');
const { Op } = require('sequelize');

const Booking = db.Booking;
const Tour = db.Tour;
const User = db.User;

// Create new booking
exports.createBooking = async (req, res) => {
  try {
    const { tourId, fullName, departureDate, participants, paymentMethod, notes } = req.body;
    const userId = req.user.id;

    // Check if tour exists
    const tour = await Tour.findByPk(tourId);
    if (!tour) {
      return res.status(404).json({
        success: false,
        message: 'Tour not found'
      });
    }

    // Calculate total price
    const totalPrice = parseFloat(tour.price) * parseInt(participants);

    // Generate unique order ID
    const orderId = 'INV-' + Date.now();

    // Handle file upload (document)
    let documentPath = null;
    if (req.file) {
      documentPath = req.file.path;
    }

    // Create booking
    const booking = await Booking.create({
      orderId,
      userId,
      tourId,
      fullName,
      departureDate,
      participants,
      totalPrice,
      documentPath,
      paymentMethod,
      notes,
      status: 'pending'
    });

    res.status(201).json({
      success: true,
      message: 'Booking created successfully',
      data: booking
    });
  } catch (error) {
    console.error('Create booking error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to create booking',
      error: error.message
    });
  }
};

// Get user's bookings
exports.getUserBookings = async (req, res) => {
  try {
    const userId = req.user.id;

    const bookings = await Booking.findAll({
      where: { userId },
      include: [
        {
          model: Tour,
          as: 'tour',
          attributes: ['id', 'name', 'location', 'image']
        }
      ],
      order: [['createdAt', 'DESC']]
    });

    res.json({
      success: true,
      count: bookings.length,
      data: bookings
    });
  } catch (error) {
    console.error('Get user bookings error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch bookings',
      error: error.message
    });
  }
};

// Get single booking by ID
exports.getBookingById = async (req, res) => {
  try {
    const { id } = req.params;
    const userId = req.user.id;

    const booking = await Booking.findOne({
      where: { id, userId },
      include: [
        {
          model: Tour,
          as: 'tour'
        }
      ]
    });

    if (!booking) {
      return res.status(404).json({
        success: false,
        message: 'Booking not found'
      });
    }

    res.json({
      success: true,
      data: booking
    });
  } catch (error) {
    console.error('Get booking error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch booking',
      error: error.message
    });
  }
};

// Update booking status (payment confirmation)
exports.updateBookingStatus = async (req, res) => {
  try {
    const { id } = req.params;
    const { status, paymentProof } = req.body;
    const userId = req.user.id;

    const booking = await Booking.findOne({
      where: { id, userId }
    });

    if (!booking) {
      return res.status(404).json({
        success: false,
        message: 'Booking not found'
      });
    }

    await booking.update({
      status: status || booking.status,
      paymentProof: paymentProof || booking.paymentProof
    });

    res.json({
      success: true,
      message: 'Booking updated successfully',
      data: booking
    });
  } catch (error) {
    console.error('Update booking error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to update booking',
      error: error.message
    });
  }
};

// Cancel booking
exports.cancelBooking = async (req, res) => {
  try {
    const { id } = req.params;
    const userId = req.user.id;

    const booking = await Booking.findOne({
      where: { id, userId }
    });

    if (!booking) {
      return res.status(404).json({
        success: false,
        message: 'Booking not found'
      });
    }

    if (booking.status === 'confirmed') {
      return res.status(400).json({
        success: false,
        message: 'Cannot cancel confirmed booking'
      });
    }

    await booking.update({ status: 'cancelled' });

    res.json({
      success: true,
      message: 'Booking cancelled successfully'
    });
  } catch (error) {
    console.error('Cancel booking error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to cancel booking',
      error: error.message
    });
  }
};
