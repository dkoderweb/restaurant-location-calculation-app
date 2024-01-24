# Restaurant Location Calculation App

This application allows users to add restaurants, specifying the restaurant name, location on a map, and delivery area range. It calculates and displays the distance from the user's current location to each restaurant, indicating whether delivery is possible based on the specified range.

## Installation

Follow these steps to set up the application:

1. Clone the repository:

   ```bash
   git clone https://github.com/dkoderweb/restaurant-location-calculation-app.git
   ```

2. Navigate to the project directory:

   ```bash
   cd restaurant-location-calculation
   ```

3. Install dependencies:

   ```bash
   composer update
   ```

4. Create a copy of the environment file:

   ```bash
   cp .env.example .env
   ```

5. Configure your database settings in the `.env` file.

6. Run the migrations:

   ```bash
   php artisan migrate
   ```

   Alternatively, you can import the provided `Restaurant.sql` file into your database.

7. Generate an application key:

   ```bash
   php artisan key:generate
   ```

8. Run the development server:

   ```bash
   php artisan serve
   ```

9. Access the application in your web browser at [http://localhost:8000](http://localhost:8000).

## Usage

1. **Add Restaurant**: Click the "Add Restaurant" button to add a new restaurant. Enter the restaurant name, select its location on the map, specify the delivery area range, and click "Save Restaurant."

2. **View Restaurant List**: On the index page, view the list of restaurants. The table displays the restaurant name, delivery area range, distance from the user, and delivery possibility.

3. **Distance Calculation**: The distance from the user's current location to each restaurant is calculated and displayed in the "Distance from User (km)" column.

4. **Delivery Possibility**: The "Delivery Possibility" column indicates whether delivery is possible based on the specified range.

Enjoy using the Restaurant Location Calculation App!
