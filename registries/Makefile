all: typeregistry.ndjson datastandards.ndjson dtr-pit.ndjson

dtr-pit.ndjson:
	curl -s 'https://dtr-pit.pidconsortium.net/objects/?query=*%3A*&pageNum=0&pageSize=200' \
	| jq -c .results[].content > $@ && wc -l $@

typeregistry.ndjson:
	curl -s 'https://typeregistry.org/objects/?query=type%3AdataType&pageNum=0&pageSize=200' \
	| jq -c .results[].content > $@ && wc -l $@

datastandards.ndjson:
	curl -s https://datastandards.directory/api/get/all | jq -c .data[] > $@ && wc -l $@
