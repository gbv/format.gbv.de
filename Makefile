.PHONY: test style web metadata

test: metadata
	composer test

style:
	composer style

init:
	composer install
	rm -rf pages/schema/avram
	git clone https://github.com/gbv/avram.git pages/schema/avram

web:
	php -S localhost:8020 -t public

metadata: formats.ndjson

formats.ndjson:
	php bin/metadata.php > $@

# formats.dot: formats.ndjson
#	perl bin/graph.pl < $< > $@
#formats.png: formats.dot
#	dot -Gbackground=white -Tpng -oformats.png formats.dot	
