# PCB Dimension Calculator

## Approach

This Laravel application calculates PCB dimensions from a Gerber ZIP file.

### Flow:

1. User uploads a Gerber ZIP file.
2. Validate file type and size.
3. Extract ZIP contents into a temporary directory.
4. Identify the PCB outline layer (`Edge_Cuts` / `Profile`).
5. Parse Gerber coordinate data.
6. Calculate PCB width and height using the outline coordinates.
7. Remove temporary files after processing.

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
