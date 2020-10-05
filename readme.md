# Text Mining Demo for Segmed
### Oct 2020

## Using vanilla Javascript and PHP to Fetch and Display Data
This project is intended to fulfill the challenge presented by Segmed for an interview.

### Description
This code allows a User to search through a number of .txt files for a search term.
- The User can find files that either contain the Search Term, or DO NOT contain the Search Term.
- When searching for files that contain the Search Term, results are provided, indicating the line number, and with the search term highlighted.
- When viewing a file on the Search Screen, the user can click on a report name (they are hyperlinks) and the File Display window will open, which will show the full text of the selected file, with line numbers and highlighted Search Term. The file name title at the top of the File Display window is a link that will open the raw text (source) file in a new tab.
- Each file link will open the File Display window in a new browser tab, allowing the user to have many files open at once. The file name is displayed in the browser tab for easy recognition.
- In the File Display window, Users can create and delete tags, whatever they want them to be. Clicking on a tag will assign or remove it from the active file, depending on whether it was already assigned or not (**toggle**). Active tags are red, inactive tags are gray.
- Tags assigned to a given file will be displayed on the Search Screen in the Search Results. Only assigned ("active") tags are displayed.


### See it Live! in action...
https://work-samples.swishersolutions.com/demos/segmed

### Installation
If you want to download this code and get it up and running in your own environment, you'll need to know a few things.
- This project is web-based, and therefore requires a web server. I use an AWS EC2 UBUNTU server running NGINX as the web server.
- The web server must run PHP 7.2 (or greater). 
- **IMPORTANT** Make sure to set the Default Document to "index.php" in your web server! Otherwise you'll get a 404 or some other error.
- Be sure that your server's web user account has read and write access to all files, but especially *tags.json*.

### Notes
I know I didn't build this ***exactly*** as described in the requirements doc, but I think that what I have created meets all the requirements, and is a pretty user-friendly tool!
- One of the requirements was showing the first sentence in bold, then the other sentences. The files I used have title and other information in the first lines, and there is no dependable way to determine where a sentence ends (i.e "Joe and Mr. Smith were friends."... where does that sentence end? Can't say on the first full-stop (period)!). So instead, I chose to show the line(s) where the Search Term appears in the file.
- I decided to forgo adding drag and drop functionality for tags, as I think I've created a better interface for managing them, and that is more in line with how (my) GMail interface for tags works. Plus, drag and drop with pure vanilla Javascript is a real pain! ;)
- I decided to forgo adding Next/Prev buttons in the Search Results as they seemed redundant. If you really want them, I can add them.
- I handled Active and Inactive tags a little differently. Seems to me that we only want to see Active tags in the Search Results. When viewing a given file in the File Display window, we can see all the tags, active and inactive. Here we can add and delete available tags, and assign them to the given report.
- I didn't quite understand how you wanted the key binding to work, so I didn't put any in. If you can elucidate that a bit for me, I can add it in.
- I needed some dummy data text files... here's where I got them: http://www.textfiles.com/fun/. There are 216 of them, on all kinds of interesting topics.
- I did not use a database, but there are 2 .json files used for data storage. One ***(file_meta.json)*** has descriptions for the files, and the other ***(tags.json)*** is where all the tag information is stored.
- All the frontend code is pure vanilla Javascript (whew!)... jQuery is included *only* for Bootstrap. No other libraries or frameworks are used.
- All the backend code is good ol' fashioned PHP. :)

### Contact
Author: **Mike Swisher** *https://work-samples.swishersolutions.com*



