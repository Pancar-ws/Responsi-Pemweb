const db = require('../config/database');
const { Op } = require('sequelize');

const Booking = db.Booking;
const Tour = db.Tour;
const User = db.User;

// Get all bookings (Admin)
exports.getAllBookings = async (req, res) => {
  try {
    const { status, startDate, endDate } = req.query;
    
    let whereClause = {};

    if (status) {
      whereClause.status = status;
    }

    if (startDate || endDate) {
      whereClause.departureDate = {};
      if (startDate) whereClause.departureDate[Op.gte] = startDate;
      if (endDate) whereClause.departureDate[Op.lte] = endDate;
    }

    const bookings = await Booking.findAll({
      where: whereClause,
      include: [
        {
          model: User,
          as: 'user',
          attributes: ['id', 'name', 'email']
        },
        {
          model: Tour,
          as: 'tour',
          attributes: ['id', 'name', 'location']
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
    console.error('Get all bookings error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch bookings',
      error: error.message
    });
  }
};

// Update booking status (Admin)
exports.updateBookingStatus = async (req, res) => {
  try {
    const { id } = req.params;
    const { status } = req.body;

    const booking = await Booking.findByPk(id);
    if (!booking) {
      return res.status(404).json({
        success: false,
        message: 'Booking not found'
      });
    }

    await booking.update({ status });

    res.json({
      success: true,
      message: 'Booking status updated successfully',
      data: booking
    });
  } catch (error) {
    console.error('Update booking status error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to update booking status',
      error: error.message
    });
  }
};

// Get dashboard statistics (Admin)
exports.getDashboardStats = async (req, res) => {
  try {
    // Total revenue
    const totalRevenue = await Booking.sum('totalPrice', {
      where: { status: 'paid' }
    });

    // Total bookings
    const totalBookings = await Booking.count();

    // Pending bookings
    const pendingBookings = await Booking.count({
      where: { status: 'pending' }
    });

    // Total tours
    const totalTours = await Tour.count({
      where: { isActive: true }
    });

    // Total users
    const totalUsers = await User.count({
      where: { role: 'user' }
    });

    // Recent bookings
    const recentBookings = await Booking.findAll({
      limit: 10,
      include: [
        {
          model: User,
          as: 'user',
          attributes: ['name', 'email']
        },
        {
          model: Tour,
          as: 'tour',
          attributes: ['name']
        }
      ],
      order: [['createdAt', 'DESC']]
    });

    res.json({
      success: true,
      data: {
        totalRevenue: totalRevenue || 0,
        totalBookings,
        pendingBookings,
        totalTours,
        totalUsers,
        recentBookings
      }
    });
  } catch (error) {
    console.error('Get dashboard stats error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch dashboard statistics',
      error: error.message
    });
  }
};

// Get all users (Admin)
exports.getAllUsers = async (req, res) => {
  try {
    const users = await User.findAll({
      attributes: { exclude: ['password'] },
      order: [['createdAt', 'DESC']]
    });

    res.json({
      success: true,
      count: users.length,
      data: users
    });
  } catch (error) {
    console.error('Get all users error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch users',
      error: error.message
    });
  }
};
