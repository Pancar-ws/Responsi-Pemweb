const db = require('../config/database');
const { Op } = require('sequelize');

const Tour = db.Tour;

// Get all tours (with filters)
exports.getAllTours = async (req, res) => {
  try {
    const { location, minPrice, maxPrice, type, search } = req.query;
    
    let whereClause = { isActive: true };

    if (location) {
      whereClause.location = { [Op.like]: `%${location}%` };
    }

    if (minPrice || maxPrice) {
      whereClause.price = {};
      if (minPrice) whereClause.price[Op.gte] = parseFloat(minPrice);
      if (maxPrice) whereClause.price[Op.lte] = parseFloat(maxPrice);
    }

    if (type) {
      whereClause.type = type;
    }

    if (search) {
      whereClause[Op.or] = [
        { name: { [Op.like]: `%${search}%` } },
        { description: { [Op.like]: `%${search}%` } }
      ];
    }

    const tours = await Tour.findAll({
      where: whereClause,
      order: [['createdAt', 'DESC']]
    });

    res.json({
      success: true,
      count: tours.length,
      data: tours
    });
  } catch (error) {
    console.error('Get tours error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch tours',
      error: error.message
    });
  }
};

// Get single tour by ID
exports.getTourById = async (req, res) => {
  try {
    const { id } = req.params;

    const tour = await Tour.findOne({
      where: { id, isActive: true }
    });

    if (!tour) {
      return res.status(404).json({
        success: false,
        message: 'Tour not found'
      });
    }

    res.json({
      success: true,
      data: tour
    });
  } catch (error) {
    console.error('Get tour error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to fetch tour',
      error: error.message
    });
  }
};

// Create new tour (Admin only)
exports.createTour = async (req, res) => {
  try {
    const { name, location, type, price, description, image, rating, facilities } = req.body;

    const tour = await Tour.create({
      name,
      location,
      type,
      price,
      description,
      image,
      rating: rating || 5.0,
      facilities: facilities || []
    });

    res.status(201).json({
      success: true,
      message: 'Tour created successfully',
      data: tour
    });
  } catch (error) {
    console.error('Create tour error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to create tour',
      error: error.message
    });
  }
};

// Update tour (Admin only)
exports.updateTour = async (req, res) => {
  try {
    const { id } = req.params;
    const { name, location, type, price, description, image, rating, facilities, isActive } = req.body;

    const tour = await Tour.findByPk(id);
    if (!tour) {
      return res.status(404).json({
        success: false,
        message: 'Tour not found'
      });
    }

    await tour.update({
      name: name || tour.name,
      location: location || tour.location,
      type: type || tour.type,
      price: price || tour.price,
      description: description || tour.description,
      image: image || tour.image,
      rating: rating || tour.rating,
      facilities: facilities || tour.facilities,
      isActive: isActive !== undefined ? isActive : tour.isActive
    });

    res.json({
      success: true,
      message: 'Tour updated successfully',
      data: tour
    });
  } catch (error) {
    console.error('Update tour error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to update tour',
      error: error.message
    });
  }
};

// Delete tour (Admin only - soft delete)
exports.deleteTour = async (req, res) => {
  try {
    const { id } = req.params;

    const tour = await Tour.findByPk(id);
    if (!tour) {
      return res.status(404).json({
        success: false,
        message: 'Tour not found'
      });
    }

    await tour.update({ isActive: false });

    res.json({
      success: true,
      message: 'Tour deleted successfully'
    });
  } catch (error) {
    console.error('Delete tour error:', error);
    res.status(500).json({
      success: false,
      message: 'Failed to delete tour',
      error: error.message
    });
  }
};
