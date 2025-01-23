# Financial Management System

## Project Description
The **Financial Management System** is a web-based application designed to streamline and manage administrative finances efficiently. This system allows the administrator to securely manage transactions, allocate funds, and track financial records with ease. Built with PHP, MySQL, and Bootstrap, it provides a user-friendly interface with secure authentication and a professional dashboard.

## Features
1. **Administrator Authentication:**
   - Secure login system with username and password.
   - "Remember Me" functionality for user convenience.

2. **Dashboard Navigation:**
   - A responsive navigation bar on the left side for easy access to features.
   - Organized links evenly distributed to cover the vertical length of the screen.

3. **Financial Management:**
   - Manage and track transactions (income, expenses, borrowing, and repayment).
   - Fund allocation into predefined categories such as salaries, academics, and projects.

4. **User Interface:**
   - Split layout with intuitive and visually appealing design.
   - Responsive design using Bootstrap for compatibility with all devices.

5. **Database Integration:**
   - MySQL database to store administrator credentials and financial data securely.

## Technologies Used
- **Frontend:** HTML, CSS, Bootstrap
- **Backend:** PHP
- **Database:** MySQL

## Project Structure
```
├── index.html               # Welcome page with administrator login
├── login.php                # Login authentication script
├── includes/
│   ├── navigation.php       # Navigation bar script
├── dashboard/
│   ├── dashboard.php        # Dashboard main file
├── assets/
│   ├── styles.css           # Additional styles
│   ├── images/              # Images used in the project
├── database/
│   ├── admin_system.sql            # SQL script for database setup
```

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Elekkein/financial-management-system.git
   ```

2. Navigate to the project directory:
   ```bash
   cd financial-management-system
   ```

3. Set up the database:
   - Import the `admin_system.sql` file in your MySQL server.
   - Update the database credentials in `login.php`.

4. Start the server:
   - Use XAMPP, WAMP, or any PHP local server to host the project.

5. Open the application:
   - Visit `http://localhost/Manager` in your browser.

## Usage
- Log in using the administrator credentials set during the database setup.
- Use the left-side navigation bar to manage finances, view reports, and track transactions.

## Future Enhancements
- Add multi-currency support.
- Implement automated email notifications for due payments.
- Create visual financial analytics dashboards.

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request for review.

## License
This project is licensed under the MIT License. See the LICENSE file for details.

---
**Author:** Mwesigwa Gilbert
**Contact:** gilbertmwesigwa6@gmail.com
