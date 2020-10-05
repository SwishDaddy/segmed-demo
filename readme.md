# Text Mining Demo for Segmed
### Oct 2020

## Using vanilla Javascript and PHP to Fetch and Display Data
This project is intended to fulfill the challenge presented by Segmed for an interview.

### Description
This code allows a User to search through a number of .txt files for a search term.
- The User can find files that either contain the Search Term, or DO NOT contain the Search Term.
- When searching for files that contain the Search Term, results are provided, indicating the line number, and with the search term highlighted.
- When viewing a file on the Search Screen (by clicking on a report name... they are hyperlinks), the File Display window will open, which show the full text of the selected file, with line numbers and highlighted Search Term. The file name title at the top is a link that will open the raw text (source) file in a new tab.
- Each file link will open the File Display window in a new browser tab, allowing the user to have many files open at once. The file name is displayed in the browser tab for easy recognition.
- In the File Display window, Users can create and delete tags, whatever they want them to be. Clicking on a tag will assign or remove it from the active file, depending on whether it was already assigned or not (**toggle**). Active tags are red, inactive tags are gray.
- Tags assigned to a given file will be displayed on the Search Screen in the Search Results. Only assigned ("active") tags are displayed.

### File Source
I needed some dummy data text files... here's where I got them: http://www.textfiles.com/fun/

### See it Live! in action...
https://work-samples.swishersolutions.com/demos/segmed

### Try it out
If you want to download this code and get it up and running in your own environment, you'll need to know a few things.
- This project is web-based, and therefore requires a web server. I use an AWS EC2 UBUNTU server running NGINX as the web server.
- The web server must run PHP 7.2 (or greater). 
- **IMPORTANT** Make sure to set the Default Document to "index.php" in your web server! Otherwise you'll get a 404 or some other error.

### Contact
Author: **Mike Swisher** *https://work-samples.swishersolutions.com*



