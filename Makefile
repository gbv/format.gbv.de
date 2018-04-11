.PHONY: test style web metadata

test: metadata
	composer test

style:
	composer style

web:
	php -S localhost:8020 -t public

metadata:
	php bin/metadata.php > pages/data/dumps/latest.json

formats.json: metadata
formats.dot: formats.json
	perl bin/graph.pl < $< > $@
formats.png: formats.dot
	dot -Gbackground=white -Tpng -oformats.png formats.dot	
