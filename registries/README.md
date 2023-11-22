This directory contains scripts to extract and transform records from other directories of data formats.

Run `make` or see `Makefile` for processing details.

## Data Type Registry

Contents of the [Data Type Registry](https://typeregistry.org/)(DTR) can be
downloaded in a custom JSON format. Records are locally stored in
`typeregistry.ndjson`. The concept of "data types" collected in this registry
does not directly map to data formats but more to conceptual entities and most
records lack examples.

## Open Data Standards Directory

The [Open Data Standards Directory](https://datastandards.directory/) was
created 2017 and has rarely been updated since. It contains 84 standards,
a large parts of which are or contain data formats:

~~~sh
jq 'select(.machine_readable=="Yes")|{name,website,machine_readable_rationale}' datastandards.ndjson
~~~
