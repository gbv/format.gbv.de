#!/usr/bin/env node

const fs = require('fs')
const path = require('path')
const yaml = require('js-yaml').safeLoad
const yfm = require('front-matter')
const argv = require('minimist')(process.argv.slice(2))

const prefix = argv.prefix || 'http://format.gbv.de/'
const root   = argv.root   || './pages/'
const lang   = argv.lang   || 'de'

function load(file) {
  var data = yfm(fs.readFileSync(file, 'utf8'))
  var item = data.attributes

  var id = prefix + path.relative(root,file).replace(/\..+$/,'')
  var description = item.description || { }
  description[item.language || lang] = data.body.trim() 
  delete item.language

  return Object.assign(item, { id, description })
}

const Ajv = require('ajv')
const ajv = new Ajv()
ajv.addMetaSchema(require('ajv/lib/refs/json-schema-draft-06.json'))
const schema = yaml(fs.readFileSync('pages/data/schema.yaml'))

const validate = ajv.compile(schema)

argv._.forEach(file => {
  var item = load(file)
  if (validate(item)) {
    console.log(JSON.stringify(item))
  } else {
    validate.errors.forEach(err => {
      err.file = file
      console.error(JSON.stringify(err))
    })
  }
})
