
# Community Helper (MAMP-ready)

A simple community help portal with:
- Register, Login, Logout
- Forgot password (token link shown for demo)
- Post Request (auto-redirect after login/register)
- Helper Desk to respond with email/phone/image
- User Dashboard shows your requests and helper responses
- Dark theme with subtle animations + chatbot widget
- Responsive layout (HTML5 + CSS3 + PHP + MySQL)

## Quick Setup (MAMP)
1. Start MAMP. Open phpMyAdmin.
2. Import `init_db.sql` (or paste in SQL tab). This creates database `community_helper`.
3. Copy this folder `community_helper_mamp` into your MAMP `htdocs` (macOS) or `htdocs` in MAMP for Windows.
4. If needed, edit `config.php` DB credentials. Default MAMP is user `root`, pass `root`, port `8889`.
5. Visit `http://localhost:8888/community_helper_mamp/` (or your MAMP port).
6. Register or login — you'll be redirected straight to **Post Request**.

## Notes
- Image uploads are stored in `/uploads` (ensure the folder is writable).
- For password reset, the link is shown on-screen (since emails are not configured locally).
- Helper role is optional; any logged in account can access Helper Desk.
