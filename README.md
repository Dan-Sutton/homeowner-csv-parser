# Homeowner Names CSV Uploader

## Overview

The Homeowner Names CSV Uploader is a web application that allows users to upload a CSV file containing homeowner names. The application parses the CSV file and displays the parsed names on the web page. It supports various name formats, including titles, first names, initials, and double-barrelled last names.

## Features

-   Upload a CSV file containing homeowner names.
-   Parse and display names with titles, first names, initials, and last names.
-   Support for multiple name formats, including double-barrelled last names.
-   Reset functionality to clear the displayed names.

## Setup Instructions

### Prerequisites

-   PHP (>= 7.3)
-   Composer
-   Laravel (>= 8.x)

### Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/yourusername/homeowner-names-uploader.git
    cd homeowner-names-uploader
    ```

````

2. **Install dependencies:**

```sh
composer install
````

3. **Start the development server:**

The application will be available at `http://localhost:8000`

### Usage

Upload a CSV File:

Open the application in your web browser.
Click the "Choose File" button and select a CSV file containing homeowner names.
Click the "Upload" button to upload and parse the CSV file.
View Parsed Names:

After uploading the CSV file, the parsed names will be displayed on the web page.
Each name will be displayed with its title, first name, initial, and last name.
Reset:

Click the "Reset" button to clear the displayed names.

### Testing

```sh
php artisan test
```

### Controllers

**HomeownerController**
Handles the upload and parsing of CSV files, and the reset functionality.
