# Project Analysis: AI Chatbot with PHP, JavaScript & Google Gemini API

## Overview
This project is a simple AI-powered chatbot for eCommerce, built using PHP, JavaScript, HTML/CSS, and the Google Gemini API. It allows users to interact with an AI assistant for product queries, order information, and general help.

---

## Technologies Used
- **Frontend:**
  - HTML5, CSS3 (custom + Bootstrap 5), JavaScript (vanilla, Fetch API)
  - FontAwesome for icons
- **Backend:**
  - PHP (API integration, DB access)
  - Google Gemini API (AI responses)
  - MySQL (product database)
- **No framework** is used (neither frontend like React/Vue nor backend like Laravel). The structure is modular but not based on any framework.

---

## File/Module Responsibilities

### 1. `index.html` / `index.php`
- **Purpose:** Main UI for the chatbot.
- **index.html:** Standalone chatbot page with embedded styles and scripts.
- **index.php:** Integrates chatbot UI with the main eCommerce site (uses shared CSS, header, etc.).
- **UI Elements:** Chat history, input box, send button, error display.

### 2. `script.js`
- **Purpose:** Handles frontend logic for sending/receiving messages.
- **Key Functions:**
  - Captures user input and sends it to `chatbot.php` via Fetch API (AJAX, JSON).
  - Updates chat history with user and bot messages.
  - Shows loading state and error messages.

### 3. `style.css`
- **Purpose:** Styles the chatbot UI (chat bubbles, layout, colors, etc.).
- **Integration:** Matches the main site's theme for a seamless look.

### 4. `chatbot.php`
- **Purpose:** Backend API endpoint for chatbot logic.
- **Key Functions:**
  - Receives user message (POST, JSON).
  - Looks up product info in the MySQL database (via `connect.php`).
  - Calls Google Gemini API for AI-generated responses.
  - Returns JSON response to frontend.
  - Handles errors and invalid input.

### 5. `components/connect.php`
- **Purpose:** Database connection module (PDO, MySQL).
- **Usage:** Included in `chatbot.php` for product lookup.

### 6. `README.md`
- **Purpose:** Project documentation, setup, and usage instructions.

---

## Project Structure: Modular or Unstructured?
- **Modular:**
  - Separate files for frontend (UI, JS, CSS) and backend (API, DB connection).
  - Each file has a clear, single responsibility.
- **Not based on any framework** (like Laravel, React, etc.), but follows good separation of concerns.

---

## Models/Database
- **Database:** MySQL (`shop_db`)
- **Table Used:** `products` (fields: name, price, details)
- **Model:** No OOP model classes; direct SQL queries via PDO.

---

## Summary Table
| File/Module         | Responsibility/Role                | Technology      |
|---------------------|------------------------------------|-----------------|
| index.html/index.php| Chatbot UI (frontend)              | HTML, CSS, JS   |
| script.js           | Frontend logic (AJAX, UI updates)  | JavaScript      |
| style.css           | Chatbot styling                    | CSS             |
| chatbot.php         | Backend API, AI & DB logic         | PHP, Gemini API |
| connect.php         | Database connection                | PHP, MySQL      |
| README.md           | Documentation                      | Markdown        |

---

## Frameworks & Libraries
- **Bootstrap 5** (CDN, for styling)
- **FontAwesome** (CDN, for icons)
- **No PHP/JS framework** (pure PHP, vanilla JS)

---

## Conclusion
- The project is **modular** (clear separation of UI, logic, backend, and DB connection).
- **No advanced framework** is used; it's built with core web technologies for simplicity and easy integration.
- **AI Model:** Google Gemini (via API, not self-hosted)
- **Database:** MySQL (for product info)

---

*This file provides a detailed analysis of the project structure, technologies, and file responsibilities.*
