Last login: Wed Sep 26 14:34:31 on console
MacBook-Air-Alexandr:~ alexandr$ sudo nano /etc/apache2/httpd.conf
Password:







































MacBook-Air-Alexandr:~ alexandr$ sudo nano /etc/apache2/httpd.conf
MacBook-Air-Alexandr:~ alexandr$ sudo chmod 777 /Library/WebServer/Documents/www
MacBook-Air-Alexandr:~ alexandr$ sudo chmod 777 /Library/WebServer/Documents/www/megapolis.loc
MacBook-Air-Alexandr:~ alexandr$ sudo chmod 775 /Library/WebServer/Documents/www/megapolis.loc
MacBook-Air-Alexandr:~ alexandr$ sudo chmod 777 /Library/WebServer/Documents/www/megapolis.loc
MacBook-Air-Alexandr:~ alexandr$ sudo nano _default.conf
MacBook-Air-Alexandr:~ alexandr$ cd
MacBook-Air-Alexandr:~ alexandr$ sudo apachectl restart
MacBook-Air-Alexandr:~ alexandr$ sudo chmod 777 /Library/WebServer/Documents
MacBook-Air-Alexandr:~ alexandr$ sudo nano /etc/apache2/httpd.conf










MacBook-Air-Alexandr:~ alexandr$ sudo apachectl restart
MacBook-Air-Alexandr:~ alexandr$ cd /private/etc/apache2/vhosts
MacBook-Air-Alexandr:vhosts alexandr$ sudo nano _default.conf
MacBook-Air-Alexandr:vhosts alexandr$ sudo apachectl restart
MacBook-Air-Alexandr:vhosts alexandr$ sudo nano /etc/apache2/httpd.conf
MacBook-Air-Alexandr:vhosts alexandr$ sudo apachectl restart
MacBook-Air-Alexandr:vhosts alexandr$ sudo chmod 775  /Library/WebServer/Documents
MacBook-Air-Alexandr:vhosts alexandr$ sudo nano /etc/apache2/httpd.conf
MacBook-Air-Alexandr:vhosts alexandr$ sudo apachectl restart
MacBook-Air-Alexandr:vhosts alexandr$ sudo nano /etc/apache2/httpd.conf

GNU nano 2.0.6                                                   File: /etc/apache2/httpd.conf                                                                                                  Modified

# included to add extra features or to modify the default configuration of
# the server, or you may simply copy their contents here and change as
# necessary.

# Server-pool management (MPM specific)
Include /private/etc/apache2/extra/httpd-mpm.conf

# Multi-language error messages
#Include /private/etc/apache2/extra/httpd-multilang-errordoc.conf

# Fancy directory listings
Include /private/etc/apache2/extra/httpd-autoindex.conf

# Language settings
#Include /private/etc/apache2/extra/httpd-languages.conf

# User home directories
#Include /private/etc/apache2/extra/httpd-userdir.conf

# Real-time info on requests and configuration
#Include /private/etc/apache2/extra/httpd-info.conf

# Virtual hosts
#Include /private/etc/apache2/extra/httpd-vhosts.conf
Include /private/etc/apache2/vhosts/*.conf

# Local access to the Apache HTTP Server Manual
#Include /private/etc/apache2/extra/httpd-manual.conf

# Distributed authoring and versioning (WebDAV)
#Include /private/etc/apache2/extra/httpd-dav.conf

# Various default settings
#Include /private/etc/apache2/extra/httpd-default.conf

# Configure mod_proxy_html to understand HTML4/XHTML1
<IfModule proxy_html_module>
  Include /private/etc/apache2/extra/proxy-html.conf
</IfModule>

# Secure (SSL/TLS) connections
#Include /private/etc/apache2/extra/httpd-ssl.conf
#
# Note: The following must must be present to support
#       starting without SSL on platforms with no /dev/random equivalent
#       but a statically compiled-in mod_ssl.
#
<IfModule ssl_module>
  SSLRandomSeed startup builtin
  SSLRandomSeed connect builtin
</IfModule>








^G Get Help                       ^O WriteOut                       ^R Read File                      ^Y Prev Page                      ^K Cut Text                       ^C Cur Pos
^X Exit                           ^J Justify                        ^W Where Is                       ^V Next Page                      ^U UnCut Text                     ^T To Spell
