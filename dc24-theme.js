const fs = require('fs');
const path = require('path');

// Path to the Tailwind CSS configuration file
const configPath = path.join(__dirname, 'tailwind.config.js');

// Read the existing configuration file
fs.readFile(configPath, 'utf8', (err, data) => {
    if (err) {
        console.error('Error reading the file:', err);
        return;
    }

    // Assume we're dealing with a simple case where we can manipulate the file as a string
    let modifiedData = data;

    // Check if 'fontSize' property already exists under 'extend'
    if (data.includes('fontSize: {')) {
        // Regex to find the fontSize block and replace it
        modifiedData = data.replace(/fontSize: {\s*[^}]*}/, `fontSize: {
            'h4': '1.25rem', // updated font size for h4
        }`);
    } else {
        // Insert the fontSize config
        modifiedData = data.replace(/extend: {/, `extend: {
            fontSize: {
                'h4': '1.25rem', // added font size for h4
            },`);
    }

    // Write the modified configuration back to the file
    fs.writeFile(configPath, modifiedData, 'utf8', (err) => {
        if (err) {
            console.error('Error writing the file:', err);
            return;
        }
        console.log('Config successfully updated.');
    });
});