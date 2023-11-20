.PHONY: test style web metadata

metadata: formats.ndjson

formats.ndjson:
	php bin/metadata.php > $@

# formats.dot: formats.ndjson
#	perl bin/graph.pl < $< > $@
#formats.png: formats.dot
#	dot -Gbackground=white -Tpng -oformats.png formats.dot	
