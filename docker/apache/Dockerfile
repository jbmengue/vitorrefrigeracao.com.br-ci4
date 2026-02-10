FROM httpd:2.4

RUN sed -i 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' /usr/local/apache2/conf/httpd.conf \
  && sed -i 's/^#LoadModule proxy_module/LoadModule proxy_module/' /usr/local/apache2/conf/httpd.conf \
  && sed -i 's/^#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' /usr/local/apache2/conf/httpd.conf \
  && sed -i 's#^DocumentRoot \"/usr/local/apache2/htdocs\"#DocumentRoot \"/var/www/public\"#' /usr/local/apache2/conf/httpd.conf \
  && sed -i 's#<Directory \"/usr/local/apache2/htdocs\">#<Directory \"/var/www/public\">#' /usr/local/apache2/conf/httpd.conf \
  && printf "\nInclude conf/extra/vitor.conf\n" >> /usr/local/apache2/conf/httpd.conf
