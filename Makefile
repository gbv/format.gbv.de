.PHONY: test style web metadata

test: metadata
	composer test

style:
	composer style

web:
	php -S localhost:8020 -t public

metadata:
	php bin/metadata.php > formats.json

