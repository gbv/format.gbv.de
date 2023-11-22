typeregistry.ndjson:
	curl -s 'https://typeregistry.org/objects/?query=type%3AdataType&pageNum=0&pageSize=200' \
	| jq -c .results[].content > $@ && wc -l $@
