.PHONY: test style web metadata

test: metadata
	composer test

style:
	composer style

init:
	rm -rf pages/schema/avram
	git clone https://github.com/gbv/avram.git pages/schema/avram

web:
	php -S localhost:8020 -t public

metadata:
	mkdir -p pages/data/dumps
	php bin/metadata.php > pages/data/dumps/latest.json

formats.json: metadata
formats.dot: formats.json
	perl bin/graph.pl < $< > $@
formats.png: formats.dot
	dot -Gbackground=white -Tpng -oformats.png formats.dot	
