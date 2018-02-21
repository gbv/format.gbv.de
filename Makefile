.PHONY: test style web

test:
	composer test

style:
	composer style

web:
	php -S localhost:8020 -t public
