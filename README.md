# PCB Dimension Calculator

A Laravel-based application that calculates PCB dimensions from Gerber ZIP files by analyzing the PCB outline data.

The application extracts the PCB outline information from Gerber files and calculates the board width and height automatically.

---

## Features

- Upload Gerber ZIP files
- File type and size validation
- Automatic PCB outline detection (`Edge_Cuts` / `Profile`)
- Gerber coordinate parsing
- Automatic PCB width and height calculation
- Display dimensions in millimeters
- Temporary file cleanup after processing

---

## Setup Instructions

## Requirements

Before running the project, make sure you have:

- PHP >= 8.2
- Composer
- Laravel 12
- Node.js and npm


## Installation

Clone the repository:

```bash
git clone <repository-url>

cd pcb-dimension-calculator
```

Install dependencies:

```bash
composer install

npm install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Start the application:

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000
```
---

## Approach

The application extracts PCB outline data from the Gerber ZIP file and calculates board dimensions using outline coordinates.

Process:

- Validate and extract Gerber ZIP file.
- Find PCB outline layer (`Edge_Cuts` / `Profile`).
- Parse X/Y coordinates.
- Calculate width and height using the bounding box approach.
- Remove temporary files after processing.

Architecture:

```
Controller
|
GerberParser Service
|
Gerber Processing
|
Dimension Result
```

Calculation:
```
Width = Maximum X - Minimum X

Height = Maximum Y - Minimum Y
```

---

## Assumptions Made

- The uploaded ZIP file contains valid Gerber files.
- The PCB outline is available in the `Edge_Cuts` or `Profile` layer.
- Gerber coordinates are in a standard format.
- PCB dimensions can be calculated using the outline coordinates.

---

## AI Tools or Libraries Used

### Libraries / Frameworks

- Laravel 12
- PHP ZipArchive (ZIP extraction)
- Laravel File Utilities (file handling)
- jQuery (client-side validation)

### AI Assistance

- Used ChatGPT to understand the Gerber file format and how PCB outline coordinates can be used to calculate board dimensions.
- Took guidance on implementing the dimension extraction logic, including parsing coordinates and calculating width and height.
- Used AI assistance for code review, debugging, and improving the implementation.

---

## Known Limitations

- Currently supports basic PCB outline dimension calculation.
- May not handle complex shapes, cutouts, slots, or advanced Gerber features.
- Different Gerber formats may require additional support.
---

## What I Would Improve With More Time

- The current solution works with Laravel and PHP. A future improvement would be using a dedicated Gerber parsing library (Python or Node.js) for better compatibility and more accurate PCB geometry handling.
- Improve PCB geometry calculation to support complex outlines, arcs, slots, and cutouts.
- Add PCB preview generation using SVG.
- Process large Gerber files asynchronously using Laravel Queues.
- Add additional features such as mm/inches display and report export.
