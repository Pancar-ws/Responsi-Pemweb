module.exports = (sequelize, DataTypes) => {
  const Booking = sequelize.define('Booking', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true
    },
    orderId: {
      type: DataTypes.STRING(50),
      unique: true,
      allowNull: false
    },
    userId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'users',
        key: 'id'
      }
    },
    tourId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: 'tours',
        key: 'id'
      }
    },
    fullName: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    departureDate: {
      type: DataTypes.DATEONLY,
      allowNull: false
    },
    participants: {
      type: DataTypes.INTEGER,
      allowNull: false,
      defaultValue: 1,
      validate: {
        min: 1
      }
    },
    totalPrice: {
      type: DataTypes.DECIMAL(12, 2),
      allowNull: false
    },
    documentPath: {
      type: DataTypes.STRING(255),
      allowNull: true,
      comment: 'Path to uploaded KTP/Passport'
    },
    status: {
      type: DataTypes.ENUM('pending', 'paid', 'confirmed', 'cancelled'),
      defaultValue: 'pending'
    },
    paymentMethod: {
      type: DataTypes.STRING(50),
      allowNull: true
    },
    paymentProof: {
      type: DataTypes.STRING(255),
      allowNull: true
    },
    notes: {
      type: DataTypes.TEXT,
      allowNull: true
    }
  }, {
    tableName: 'bookings',
    timestamps: true,
    indexes: [
      {
        unique: true,
        fields: ['orderId']
      },
      {
        fields: ['userId']
      },
      {
        fields: ['tourId']
      },
      {
        fields: ['status']
      }
    ]
  });

  return Booking;
};
