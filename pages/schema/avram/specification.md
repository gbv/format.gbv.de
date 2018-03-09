---
title: Avram Specification
short: Avram
language: en
---

**Avram** is a [schema language](../../schema) for [MARC](../../marc) and
related formats such as [PICA](../../pica) and [MAB](../../mab).

* author: Jakob Voß
* version: 0.1.1
* date: 2018-03-09

## Introduction

MARC and related formats are used since decades as the basis for library
automation. Several variants, dialects and profiles exist for different
applications. The Avram schema language shall allow to specify individual
formats based on MARC, PICA and similar standards for documentation,
validation, and requirements engineering.

The schema format is named after [Henriette D. Avram
(1919-2006)](https://en.wikipedia.org/wiki/Henriette_Avram) who devised MARC as
the first automated cataloging system in the 1960s.

This document consists of specification of the [schema format](#schema-format)
and [validation rules](#validation-rules).

### Conformance requirements

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [RFC 2119].

### Data types

A **timestamp** is a date or datetime as defined with XML Schema datatype
[datetime](https://www.w3.org/TR/xmlschema-2/#dateTime)
(`-?YYYY-MM-DDThh:mm:ss(\.s+)?(Z|[+-]hh:mm)?`)
[date](https://www.w3.org/TR/xmlschema-2/#date) (`-?YYYY-MM-DD(Z|[+-]hh:mm)?`),
[gYearMonth](https://www.w3.org/TR/xmlschema-2/#gYearMonth) (`-?YYYY-MM`),
or [gYear](https://www.w3.org/TR/xmlschema-2/#gYear) (`-?YYYY`).

A **regular expression** is a string e in the [ECMA 262 (2015) regular expression
grammar](http://www.ecma-international.org/ecma-262/6.0/index.html#sec-patterns).
The expression is interpreted as Unicode pattern.

## Schema format

An **Avram Schema** is a JSON object given as JSON document or any other format
that encodes a JSON document. In contrast to [RFC 7159], all object keys MUST
be unique. The schema MUST contain:

* key `fields` with a [field schedule](#field-schedule)

The schema SHOULD contain keys documenting the format defined by the schema:

* key `title` with the name of the format
* key `description` with a short description of the format
* key `url` with a homepage URL of the format

The schema MAY contain:

* key `$schema` with an URL of an [Avram metaschema](#metaschema)

*Example:*

~~~json
{
  "$schema": "https://format.gbv.de/schema/avram/schema.json",
  "title": "MARC 21 Format for Classification Data",
  "description": "MARC format for classification numbers and captions associated with them",
  "url": "https://www.loc.gov/marc/classification/",
  "fields": { }
}
~~~

String values such as values of key `title` and `description` SHOULD NOT be
empty if the corresponding key is given.

#### Field schedule

[field schedule]: #field-schedule

A **field schedule** is a JSON object that maps [field
identifiers](#field-identifier) to [field definitons](#field-definition).

*Example:*

~~~json
{
  "010": { "label": "Library of Congress Control Number" },
  "084": { "label": "Classification Scheme and Edition" }
}
~~~

#### Field identifier

A **field identifiers** is can be any non-empty string that uniquely identfies
a field. The identifier consists of a **field tag**, optionally followed by `/`
and a **field occurrence**. Applications SHOULD add further restrictions on
field identifier syntax.

For formats based on MARC a field identifiers MUST be field tags being

* either the character sequence `LDR` for specification of the record leader,
* or three digits (e.g. `001`).

For PICA-based formats 

* the field tag MUST be three digits, the first `0` to `2`, followed by an
  uppercase letter (`A` to `Z`) or `@`, and
* the field occurrences MUST be three digits and MUST NOT exist if the field
  tag starts with a digit other than `0`.

*Examples:*

* `LDR`, `001`, `850`... (MARC)
* `021A`, `045B/00`, `209K`... (PICA)

#### Field definition

[field definition]: #field-definition

A **field definition** is a JSON object that SHOULD contain:

* key `tag` with the field tag
* key `label` with the name of the field
* key `repeatable` with a boolean value, assumed as `false` by default
* key `required` with a boolean value, assumed as `false` by default

The field definition MAY further contain:

* key `url` with an URL link to documentation
* key `occurrence` with the field occurrence
* key `indicator1` with first [indicator]
* key `indicator2` with second [indicator]
* key `pica3` with corresponding Pica3 number
* key `positions` with a specification of [positions] (for fixed fields)
* key `subfields` with a [subfield schedule] (for variable fields)
* key `types` with specification of [field types]
* key `modified` with a timestamp

If a field definition is given in a [field schedule], the `tag` and
`occurrence` MUST either match the corresponding field identifier or both be
missing.

A field definition MUST NOT have more than one of the keys `positions` (for
fixed fields), `subfields` (for variable fields) or `types` (for alternatives).

*Example:*

In the following example MARC field `007` byte position `00` has the fixed
value `c` for Electronic resources:

~~~json
{
  "tag": "007",
  "label": "Physical Description",
  "types": {
    "Electronic resource": {
      "positions": {
		"00": {
          "label": "Category of material",
          "url": "https://www.loc.gov/marc/bibliographic/bd007c.html",
          "codes": {
		    "c": {
              "label": "Electronic resource"
            }
          }
        }
      }
    },
    ...
~~~

#### Field types

[field types]: #field-types

**Field types** are alternative sets of [positions] or [subfield schedules] as
part of a [field definition]. A specification of field types is a JSON object
maps type names to JSON objects either all having field `positions` or all
having field `subfields`.

#### Positions

[positions]: #positions

Fixed fields can be specified with a JSON object that maps **character
positions** to data element definitions. A character position is either two
digits (e.g.  `09`) or two digits followed by `-` and another two digits (e.g.
`12-16`). A **data element definition** is a JSON object that SHOULD contain:

* key `label` with the name of the data element

The data element definition MAY further contain:

* key `url` with an URL link to documentation
* key `codes` with a [codelist]
* key `deprecated-codes` with a [codelist] of deprecated codes

#### Subfield schedule

[subfield schedule]: #subfield-schedule
[subfield schedules]: #subfield-schedule

A **subfield schedule** is a JSON object that maps subfield codes to subfield
definitions.  A **subfield code** is a single character. A **subfield
definition** is a JSON object that SHOULD contain:

* key `code` with the subfield code
* key `label` with the name of the subfield
* key `repeatable` with a boolean value, assumed as `false` by default
* key `required` with a boolean value, assumed `false` by default

The subfield schedule MAY further contain:

* key `pattern` with a regular expression
* key `url` with an URL link to documentation
* key `order` with a non-negative integer used to specify a partial or complete order
  of subfields
* key `pica3` with a corresponding Pica3 syntax definition
* key `modified` with a timestamp

#### Indicators

[indicator]: #indicators

An **indicator** is either the value `null` or a JSON object that SHOULD contain:

* key `label` with the name of the indicator

The indicator MAY further contain:

* key `url` with an URL link to documentation
* key `codes` with a [codelist]
* key `deprecated-codes` with a [codelist] of deprecated codes


#### Codelist

[codelist]: #codelist

A **codelist** is a JSON object that maps values to descriptions. Each
description is a JSON object with key `label`.

*Example:*

~~~json
{
  " ": {
    "label": "No specified type"
  },
  "a": {
    "label": "Archival"
  }
}
~~~

### Metaschema

A [JSON Schema](http://json-schema.org/) to validate Avram Schemas is available
at <https://format.gbv.de/schema/avram/schema.json>.

Applications MAY extend the metaschema for particular formats, for instance the
further restrict the allowed set of [field identifiers](#field-identifier).

## Validation rules

*Rules how to validate records against Avram Schemas have not been specified
explicitly yet.*

An Avram schema can be used to check:

* whether all fields and subfields of a given record have been defined
* whether defined fields and subfields of a given record conform the their definition

## References

### Normative references

* P. Biron, A. Malhotra: *XML Schema Part 2: Datatypes Second Edition*.
  W3C Recommendation, October 2005.
  <https://www.w3.org/TR/xmlschema-2/>

* S. Bradner: *Key words for use in RFCs to Indicate Requirement Levels*.
  RFC 2119, March 1997. <https://tools.ietf.org/html/rfc2119>

* T. Bray: *The JavaScript Object Notation (JSON) Data Interchange Format*.
  RFC 7159, March 2014. <https://tools.ietf.org/html/rfc7159>

* *ECMAScript 2015 Language Specification (ECMA-262, 6ᵗʰ edition)*
   June 2015. <http://www.ecma-international.org/ecma-262/6.0/>

[RFC 2119]: https://tools.ietf.org/html/rfc2119
[RFC 7159]: https://tools.ietf.org/html/rfc7159

### Informative references

* <http://pkiraly.github.io/2018/01/28/marc21-in-json/>
* [MARCspec - A common MARC record path language](http://marcspec.github.io/MARCspec/marc-spec.html)

### Changes

#### 0.1.1 (2018-03-09)

* Add `pattern` field

#### 0.1.0 (2018-02-20)

* First version

