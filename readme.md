# Laravel Nova Field - Array Images
A laravel nova field that will let you save your uploaded images path to your database in array format, change
to make paths in json data relative.

# Installation
```
```

# Usage
Create array images just call `TriadLtd\ArrayFiles\ArrayFiles` class and use `make` static method to create a field.
```
...
use TriadLtd\ArrayFiles\ArrayFiles;
...
public function fields(Request $request)
    {
        return [
            ...
            ArrayFiles::make('Files', 'files'),
            ...
        ];
    }
...
```
That will create a field with name `Files`. Stored data will look like this.
```
[{
    "url": "/storage/original-file-name.pdf",
    "name": "original-file-name.pdf"
}, {
    "url": "/storage/original-file-name.docx",
    "name": "original-file-name.docx"
}, {
    "url": "/storage/original-file-name.zip",
    "name": "original-file-name.zip"
}]
```

# Notes
- make sure you have specified correct `APP_URL` on your application
- make sure you have specified default `FILESYSTEM_DRIVER` on your application
