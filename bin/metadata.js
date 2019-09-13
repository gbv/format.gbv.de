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

  // not part of the format data
  'css javascript language'.split(' ').forEach(key => delete item[key])

  return Object.assign(item, { id, description })
}

const Ajv = require('ajv')
const ajv = new Ajv()
ajv.addMetaSchema(require('ajv/lib/refs/json-schema-draft-06.json'))
const schema = yaml(fs.readFileSync('pages/data/schema.yaml'))

const validate = ajv.compile(schema)

const pages = {}
argv._.map(file => load(file)).forEach(item => pages[item.id] = item)

var errCount = 0
Object.values(pages).forEach(item => {
  var errors = []

  if (validate(item)) {
    console.log(JSON.stringify(item))
  } else {
    errors.push(...validate.errors)
  }
 
  // check links
  'model for over base profiles'.split(' ')
    .filter(key => item[key]).forEach(key => {
      const values = item[key]
      ;(typeof values === 'string' ? [values] : values).forEach(id => {
        if (!pages[prefix + id]) {
          errors.push({[key]: id, message: "broken link"})
        }
      })
    })
   
  errors.forEach(err => {
    err.id = item.id
    console.error(JSON.stringify(err))
    errCount++
  })
})

process.exit(errCount ? 1 : 0)
