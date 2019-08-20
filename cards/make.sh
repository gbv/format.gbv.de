#!/bin/bash

cat head.html

grep -rl '<example' ../pages | egrep '.md$' | while read file
do
    name=$(basename ${file%.md})
    sed -n '/<example/, /example>/ p' $file | \
    sed "s/<example>/<div class='card' title='$name'><pre><code class='language-plaintext'>/" | \
    sed "s/<example highlight=\"\\([^\"]\\+\\)\">/<div class='card' title='$name'><pre><code class='language-\\1'>/" | \
    sed 's/^<\/example>/<\/pre><\/code><\/div>/' 
done

cat foot.html
