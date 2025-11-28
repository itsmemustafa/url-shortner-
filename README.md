# Simple PHP URL Shortener

## What is this?
This is a lightweight, single-page URL shortener built with PHP. It uses a JSON file (`urls.json`) to store data, so no database setup (like MySQL) is required. It features a modern interface, click tracking, and QR code generation.

## How to Run
1. **Prerequisites**: You need a local server environment with PHP installed (e.g., XAMPP, WAMP, MAMP, or PHP's built-in server).
2. **Installation**:
   - Place the project folder in your server's root directory (e.g., `C:\xampp\htdocs\URL-shortner`).
   - Ensure the `urls.json` file has write permissions so the script can save new URLs.
3. **Start Server**: Start Apache via your XAMPP/WAMP control panel.
4. **Access**: Open your web browser and go to `http://localhost/URL-shortner` (or the corresponding path where you placed the files).

## How to Use
1. **Shorten a Link**: Paste a long URL into the input box and click the "Shorten" button.
2. **Copy & Share**: Copy the generated short link.
3. **Track Stats**: Scroll down (or check the dashboard section) to view a list of your shortened URLs, see how many times they've been clicked, and view/download their QR codes.
