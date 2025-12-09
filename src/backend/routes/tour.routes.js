const express = require('express');
const router = express.Router();
const tourController = require('../controllers/tour.controller');
const { authMiddleware, adminMiddleware } = require('../middleware/auth.middleware');

// Public routes
router.get('/', tourController.getAllTours);
router.get('/:id', tourController.getTourById);

// Admin only routes
router.post('/', authMiddleware, adminMiddleware, tourController.createTour);
router.put('/:id', authMiddleware, adminMiddleware, tourController.updateTour);
router.delete('/:id', authMiddleware, adminMiddleware, tourController.deleteTour);

module.exports = router;
