### 0.3.0

- **BREAKING CHANGE**: Changed the entry class (WpVite) into an instantiable class rather than static since the latter broke multiple uses of the enqueue function
- Removed call to `run` from the plugin entry. Setup is now done when you instantiate the class for the first time
- Added static `$init` property to ensure that the script tag filter is only applied once.

### 0.2.5

- Renamed assets banner
- Extracted changelog to separate .md file
- Added regex for release asset

### 0.2.4

- Readme fixes for params

### 0.2.3

- Added version to entry file
- Attempt fix for param table

### 0.2.2

- Screenshot added to assets
- Updated readme file

### 0.2.1

- Added 'admin' param for loading scripts on admin pages

### 0.2.0

- Added version cache-busting to both scripts and styles

### 0.1.0

- Initial release
