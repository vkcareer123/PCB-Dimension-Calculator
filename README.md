# PCB Dimension Calculator

A Laravel-based application that calculates PCB dimensions from Gerber ZIP files by analyzing the PCB outline data.

The application extracts the PCB outline information from Gerber files and calculates the board width and height automatically.

---

## Features

- Upload Gerber ZIP files
- File type and size validation
- Gerber Job (`.gbrjob`) support for direct dimension extraction
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
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

```bash
php artisan migrate
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
## PCB Dimension Calculation

The application extracts PCB dimensions from the uploaded Gerber ZIP file.

**Process:**

- Validate and extract the Gerber ZIP file.
- Check for a **Gerber Job (`.gbrjob`)** file.
- If a `.gbrjob` file is present and contains board dimensions, read the width and height directly from it.
- Otherwise, locate the PCB outline layer (`Edge_Cuts` / `Profile`).
- Parse the outline X/Y coordinates.
- Calculate the board dimensions using the bounding box approach.
- Remove temporary files after processing.

**Architecture:**

```text
Controller
    │
    ▼
GerberParser Service
    │
    ├── Gerber Job (.gbrjob)
    │       │
    │       └── Read Width & Height
    │
    └── Edge_Cuts / Profile
            │
            └── Parse Coordinates
                    │
                    ▼
            Calculate Dimensions
                    │
                    ▼
            Return Result
```

### Dimension Calculation

**When `.gbrjob` is available**

```text
Width  = GeneralSpecs.Size.X

Height = GeneralSpecs.Size.Y
```

**Fallback (Edge_Cuts/Profile)**

```text
Width  = Maximum X - Minimum X

Height = Maximum Y - Minimum Y
```

---

## Assumptions Made

- The uploaded ZIP file contains valid Gerber files.
- If a **Gerber Job (`.gbrjob`)** file is present, it contains valid board dimensions.
- If no `.gbrjob` file is available, the PCB outline exists in the `Edge_Cuts` or `Profile` layer.
- Gerber coordinates follow the standard Gerber format.
- The PCB dimensions can be determined either from the Gerber Job file or by calculating the bounding box of the PCB outline.
 
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

- Falls back to parsing the `Edge_Cuts`/`Profile` layer when a `.gbrjob` file is unavailable or does not contain board dimensions.
- The current implementation uses a bounding-box calculation and may not fully support complex PCB geometries such as internal cutouts, slots, or curved outlines.
- Additional Gerber dialects or non-standard coordinate formats may require further support.
---

## What I Would Improve With More Time

- The current solution works with Laravel and PHP. A future improvement would be using a dedicated Gerber parsing library (Python or Node.js) for better compatibility and more accurate PCB geometry handling.
- Improve PCB geometry calculation to support complex outlines, arcs, slots, and cutouts.
- Add PCB preview generation using SVG.
- Process large Gerber files asynchronously using Laravel Queues.
- Add additional features such as mm/inches display and report export.
