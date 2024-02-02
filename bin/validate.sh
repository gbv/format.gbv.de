#!/usr/bin/bash

invalid() {
  jq -c "$1" formats.ndjson
}

# All formats have an Application (except Codes)
invalid 'select(.application or (.model and .base)|not)'

# Codes of another format should not have explicit Application
invalid 'select(.model and .base and .application)'

# Query and Patch formats must reference exactely one format with `for`
invalid '.application as $a|select($a and ((if $a|type=="array" then $a else [$a] end)[]|select(.=="query" or .=="patch")))|select(.for|type!="string")'

# This is covered by inference
# invalid 'select(.subsetof and (.base or .for))|{base,for,id}'


# Only Codes (including formats being their own model) can have schemas?
# No: schemas can apply to models too
# jq -c 'select(.schemas and (.base|not))|.id' formats.ndjson

