=== Cubit Calculator Number Grid ===
Contributors: cccreading
Tags: cubit, sequence, numbers, maths
Requires at least: 6.2
Requires PHP: 8.1
Tested up to: 6.5.5
Stable tag: 1.3.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Royal Cubit calculator number grid to your site as a shortcode

== Description ==

The precise Royal Cubit (rc) - Paisley's number sequence, is our ONE Universal Tool to compare Sacred Measurements in Numbers. A working tool to also accurately compare lengths and distances in between ancient artifacts and structures.

As outlined in The Divinity DΦdeca, the precise Royal Cubit (rc) is the original unit of measurement for all valuations in our Kingdom. Resynchronization creates alignment with the true Speed of Light, bringing all lost knowledge into Unified clarity Revelation by Revelation.

[View full description](https://cubit-calculator.one/wordpress-cubit-plugin/)

This plugin provides a shortcode called cubit_number_grid you can use like this:

`[cubit_number_grid]`

`[cubit_number_grid headings=true rows=12 decimals=8]`

`[cubit_number_grid type="paisley" caption="Paisley sequence"]`

`[cubit_number_grid type="chi" caption="Xiquence"]`

=== Parameters ===

* **type** string (default=paisley) What type of number grid to use, "paisley" or "chi"
* **headings** bool (default=false) Enable/disable column headings
* **rows** int (default=9) Number of rows to show
* **animate** bool (default=true) Add a short delay between updating the fields
* **caption** string Custom caption to show below thenumber grid
* **decimals** int (default=6) How many decimal places to show in each field
* **sharing** bool (default=true) Enable/disable the share-as-link button
* **copycsv** bool (default=true) Enable/disable the copy-as-csv button

== Screenshots ==

1. Empty number grid
2. Enter a number and the sequence will populate the row from left-to-right
3. Nine rows by default. Use the rows parameter of the shortcode for more

== Changelog ==

## Version 1.3.2

*Released 14th July 2024*

* More minor adjustments to the Xi sequence. Looks good now.

## Version 1.3.1

*Released 13th July 2024*

* Adjusted the maths in the Xi sequence number progression.

## Version 1.3.0

*Released 5th July 2024*

* Added an the type="..." option to the shortcode so you can choose to a "paisley" or a "chi" number grid.
* Tidied up some more rounding, so numbers like 302.3999999 will round up to 302.4.
* Fixed a problem with the copy/share buttons when multiple number grids are on the same page.

## Version 1.2.0

*Released 3rd July 2024*

* New function to export/share number grids by copying to the clipboard as CSV data
* Tidier rounding of numbers like 3000.00004 -> 3000

## Version 1.1.0

*Released 19th April 2024*

* New function to export/share number grids by copying a share-link

## Version 1.0.2

*Released 28th January 2024*

* Added sv-SE language
* Updated the readme with a link to more info on the maths and some screenshots
* Added ×8640 to the Yard column header

## Version 1.0.1

*Released 16th January 2024*

* Added en-GB language, although there isn't much to translate here

## Version 1.0.0

*Released 10th November 2023*

* Initial release for code-review by wordpress.org

