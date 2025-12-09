const { Sequelize } = require('sequelize');

const sequelize = new Sequelize(
  process.env.DB_NAME || 'explore_papua',
  process.env.DB_USER || 'root',
  process.env.DB_PASSWORD || '',
  {
    host: process.env.DB_HOST || 'localhost',
    port: process.env.DB_PORT || 3306,
    dialect: 'mysql',
    logging: process.env.NODE_ENV === 'development' ? console.log : false,
    pool: {
      max: 5,
      min: 0,
      acquire: 30000,
      idle: 10000
    }
  }
);

const db = {};

db.Sequelize = Sequelize;
db.sequelize = sequelize;

// Import models
db.User = require('../models/User.model')(sequelize, Sequelize);
db.Tour = require('../models/Tour.model')(sequelize, Sequelize);
db.Booking = require('../models/Booking.model')(sequelize, Sequelize);

// Define associations
db.User.hasMany(db.Booking, {
  foreignKey: 'userId',
  as: 'bookings'
});

db.Booking.belongsTo(db.User, {
  foreignKey: 'userId',
  as: 'user'
});

db.Tour.hasMany(db.Booking, {
  foreignKey: 'tourId',
  as: 'bookings'
});

db.Booking.belongsTo(db.Tour, {
  foreignKey: 'tourId',
  as: 'tour'
});

module.exports = db;
