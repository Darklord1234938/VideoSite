# 🎬 Video Site — PHP Streaming Backend

A PHP backend for video streaming that implements the HTTP Range request protocol — the same mechanism used by YouTube and Netflix for video seeking and buffering.

---

## 📁 Project Structure

```
Video/
├── index.php        # Entry point (in progress)
├── video.php        # Video streaming endpoint — handles Range requests
├── thumbnail.php    # Thumbnail listing endpoint
└── database.php     # Full video metadata endpoint
```

---

## 🔌 Endpoints

### `video.php` — Stream a video
**Method:** `POST`
**Params:** `title` — the title of the video to stream

Returns the video file as `video/mp4` with full support for HTTP Range requests (`206 Partial Content`). This allows video players to seek to any position and buffer efficiently.

```http
POST /video.php
Content-Type: application/x-www-form-urlencoded

title=MyVideo
```

---

### `database.php` — Get all video metadata
**Method:** `GET`

Returns a JSON array of all videos with full metadata. Thumbnails are base64-encoded inline.

```json
[
  {
    "id": 1,
    "title": "My Video",
    "description": "...",
    "thumbnail_url": "base64encodedimage...",
    "duration": "1:32",
    "genres": "Action",
    "age": "16+",
    "uploaded_at": "2025-01-01",
    "video_url": "/videos/myvideo.mp4",
    "director": "...",
    "cast": "...",
    "visibility": "public"
  }
]
```

---

### `thumbnail.php` — Get thumbnail list
**Method:** `GET`

Returns a JSON array of title + thumbnail URL pairs for listing videos.

---

## 🗄️ Database Schema

```sql
CREATE TABLE Videos (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  title           VARCHAR(255),
  description     TEXT,
  thumbnail_url   VARCHAR(500),
  duration        VARCHAR(20),
  genres          VARCHAR(255),
  age             VARCHAR(10),
  uploaded_at     DATE,
  video_url       VARCHAR(500),
  director        VARCHAR(255),
  cast            TEXT,
  visibility      VARCHAR(20)
);
```

---

## 🚀 Getting Started

### Requirements

- PHP 8+
- MySQL / MariaDB
- A web server (Apache / Nginx) or `php -S`

### 1. Set up the database

Create a database called `video` and run the schema above.

### 2. Configure credentials

Update the connection details in each `.php` file:

```php
$servername = "127.0.0.1";
$username   = "root";
$password   = "your_password";
$dbname     = "video";
```

> ⚠️ Move credentials to a `.env` file or `config.php` before deploying — never hardcode passwords in production.

### 3. Start the server

```bash
php -S localhost:8000
```

---

## 🛠️ Tech Stack

- **PHP** — Backend logic
- **MySQL** — Video metadata storage
- **HTTP Range Requests** — Video seeking and buffering (RFC 7233)
- **Base64** — Inline thumbnail encoding

---

## 📌 Known Issues

- SQL injection vulnerability in `video.php` — `WHERE title = '$title'` should use prepared statements
- Syntax error in `thumbnail.php` — trailing comma in `SELECT id, title, thumbnail_url,`
- Typo in `database.php` — `descriptio` should be `description`
- `index.php` is empty — frontend not yet implemented
- Credentials hardcoded in plain text — should use environment variables

---

## 🔮 Planned Features

- [ ] Frontend video player (HTML + JS)
- [ ] Upload endpoint
- [ ] Authentication / user accounts
- [ ] Search and filter by genre
- [ ] View count tracking

---

## 👤 Author

**Quidon Roethof** — [github.com/Darklord1234938](https://github.com/Darklord1234938)
