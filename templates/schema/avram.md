---
title: Avram Schema Language
shorttitle: Avram
language: en
---

**Avram** is a [schema language](../schema) for [MARC](../marc) and related
standards such as [PICA](../pica) and [MAB](../mab). 

The schema language is currently being defined, so feedback is very welcome!

## Introduction

MARC is used since decades as the basis for library automation all over the
world. However there is not one format but a set of variants, dialects, and
related formats. Specification of each indiviual format has not been given in
machine readable form but as human-readable documentation (if at all).

Avram shall allow to specify MARC based formats for documentation, validation,
and requirmenets engineering.

## Specification

Most JSON fields are optional. Mandatory fields are given **`bold`**.

#### Root element

An Avram schema is a JSON document. It MUST be a JSON object with any of this
fields:

| | |
| ------------- | --------------------------|
| `title`       | name of the format defined by this schema |
| `description` | short description of the format defined by this schema |
| `url`         | homepage of the format defined by this schema |
| **`fields`**  | JSON object mapping field identifiers to field definitions |

Example:

~~~json
{
  "title": "MARC 21 Format for Classification Data",
  "url": "https://www.loc.gov/marc/classification/",
  "fields": { }
}
~~~

#### Field definitions

Field definitions are identified by a **field identifiers** which can be any of

* the character sequence `LDR` for specification of the record leader
* three digits (e.g. `001`)
* three digits, the first 0 to 2, followed by an uppercase letter or `@`, 
  optionally followed `/` and two or three digits in brackets (e.g. 
  `021A`, `045B/00`)

A **field definition** is a JSON object with any of this fields:

| | |
|
| `label` | name of the field |
| `repeatable` | a boolean value (default: `false`) |
| `required` | a boolean value (default: `false`) |
| `url` | link to documentation |
| `tag` | field identifier without occurrence |
| `indicator1` | first indicator |
| `indicator2` | second indicator |
| `occurrence` | field occurrence (only relevant in PICA+ |
| `pica3` | corresponding Pica3 number |
| `positions` | specification of positions (for fixed fields) |
| `subfields` | specification of subfields (for variable fields) |
| `types` | specification of alternative sets of subfields or positions |
| `modified` | timestamp |

The field identifier MUST be identical to the value of `tag` (if this field is
given) or `tag` and `occurrence` connected by `/` (if both fields are given).

Only one of `positions` (for fixed fields), `subfields` (for variable fields)
or `types` (for alternatives) is allowed.

The value of `types`, if given, MUST be a JSON array that maps type names to JSON objects
either all having field `positions` or all having field `subfields`.

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

#### Positions

Fixed fields can be specified with a JSON object that maps **byte positions**
to data element definitions. A byte position is either two digits (e.g.
`09`) or two digits followed by `-` and another two digits (e.g. `12-16`). A
**data element definition** is a JSON object with any of this fields:

| | |
|
| `label` | name of the data element |
| `url` | link to documentation |
| `codes` | codelist |
| `deprecated-codes` | deprecated codelist |

#### Subfields

Subfields are specified as JSON object mapping subfield codes to subfield
definitions. A **subfield code** is a single character. A **subfield
definition** is a JSON object with this fields:

| | |
|
| `code` | code of the subfield |
| `label` | name of the subfield |
| `url` | link to documentation |
| `repeatable` | a boolean value (default: `false`) |
| `required` | a boolean value (default: `false`) |
| `order` | non-negative integer |
| `pica3` | corresponding Pica3 syntax |
| `modified` | timestamp |

The `order` value, if given, optionally implies a subfield order. Incomplete
orders are allowed, e.g. to place some a subfield after another and letting the
other subfields unordered.

#### Indicators

Indicators can be specified as `null` or as JSON object with this fields:

| | |
|
| `label` | name of the indicator |
| `url` | link to documentation |
| `codes` | codelist |
| `deprecated-codes` | deprecated codelist |

#### Codelist

A **codelist** is a JSON object that maps values to descriptions.

Example:

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


## See also

* <http://pkiraly.github.io/2018/01/28/marc21-in-json/>
* <https://github.com/gbv/format.gbv.de/wiki/Schema>
* [MARCspec - A common MARC record path language](http://marcspec.github.io/MARCspec/marc-spec.html)

