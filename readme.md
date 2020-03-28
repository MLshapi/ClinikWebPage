How to set up:
1) download xampp for windows: https://www.apachefriends.org/index.html
2) install xampp anywhere you want
3) go to the folder you downloaded xampp, open htdocs folder
4) clone repository into htdocs so that it is htdocs/projectname
5) go to the previous directory of your xampp folder and find xampp-control.exe
6) click on xampp-control.exe and open
7) click on start for both APACHE and MySQL
8) go to php my admin type http://localhost/phpmyadmin/ in the search bar of your browser
9) import database the file is tables.db in the Comp353 folder
10) to access the website type http://localhost/ClinicWebPage/ in the search bar of your browser
11) Please create a new branch from Master and start developping from it, when you are done make a pull request to merge into master

What needs to be done:
1) Implement the queries in the website (the skeleton is ready, waiting for the queries)
2) Implement in the data manipulation page the following:
	- schedule new appointments 
	- modify and delete existing appointments.
3) Fix issues:
	- (I didnt do this part properly) fix the show all appointment, bills, etc, because you need to click on it twice for the table to appear
	- (I tried to fix this but couldnt) Notice: Undefined index: query in C:\Users\Mutsu\Desktop\phpcode\xampproject\htdocs\Comp353\dba.php on line 58
	  this issue is because the value in post is empty, on page load the php code tries to access the $_POST['Query'] value
4) Exception handling:
	- right now there is no exception handling in DBA page, if there is a bad request --> error appears



