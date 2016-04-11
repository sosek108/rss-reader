# rss-reader

# Installation
* dodaj to w pliku config/app.php
 Sosek\RssReader\RssReaderServiceProvider::class 
 
* uruchom artisan vendor:publish

* uruchom artisan migrate

* przejdz na strone HOST/rss
 
# Założenia projektowe
* niewymagane sprawdzanie poprawności pliku xml. Zalozylem, ze plik bedzie zgodny ze standardem ATOM.
* niewymagane użycie narzędzi frontendowych (gulp etc)

