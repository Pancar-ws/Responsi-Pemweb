module.exports = (sequelize, DataTypes) => {
  const Tour = sequelize.define('Tour', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true
    },
    name: {
      type: DataTypes.STRING(150),
      allowNull: false
    },
    location: {
      type: DataTypes.STRING(100),
      allowNull: false
    },
    type: {
      type: DataTypes.ENUM('Open Trip', 'Private'),
      defaultValue: 'Open Trip'
    },
    price: {
      type: DataTypes.DECIMAL(12, 2),
      allowNull: false,
      validate: {
        min: 0
      }
    },
    description: {
      type: DataTypes.TEXT,
      allowNull: true
    },
    image: {
      type: DataTypes.STRING(255),
      allowNull: true
    },
    rating: {
      type: DataTypes.DECIMAL(2, 1),
      defaultValue: 5.0,
      validate: {
        min: 0,
        max: 5
      }
    },
    facilities: {
      type: DataTypes.JSON,
      allowNull: true,
      defaultValue: []
    },
    isActive: {
      type: DataTypes.BOOLEAN,
      defaultValue: true
    }
  }, {
    tableName: 'tours',
    timestamps: true
  });

  return Tour;
};
