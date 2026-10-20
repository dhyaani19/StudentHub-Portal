STUDENT HUB PORTAL — PRACTICAL 10
=================================

Requirements:
- XAMPP for macOS with Apache, MySQL and PHP
- A browser

INSTALLATION:
1. Extract the folder "Pra 10" into /Applications/XAMPP/htdocs/
   The final path should be /Applications/XAMPP/htdocs/Pra 10/
2. Open XAMPP and start Apache and MySQL.
3. Open http://localhost/Pra%2010/setup.php
   The script creates the studenthub database (if needed), tables, and a demo student account.
4. Open http://localhost/Pra%2010/
5. Demo student login:
   Enrollment: 25DCE032
   Password: Student@123

IMPORTANT:
- Delete setup.php after setup is complete.
- Change the demo password and do not use demo credentials for real information.
- To grant admin access, register an account, then in phpMyAdmin select database studenthub,
  open table students, edit that account's role from student to admin.
- This is a local educational project. Before public deployment, add CSRF protection,
  rate limiting, HTTPS, a proper least-privilege database account, and review all security settings.
- Attendance, results, timetable, and events are illustrative sample content. They are not linked
  to official university systems.
- If your MySQL root account has a password, edit db.php and pass it as the third argument
  in new mysqli("localhost", "root", "YOUR_PASSWORD").
- Session inactivity timeout is 15 minutes. Remember-me tokens are stored hashed in the database.
