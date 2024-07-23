#!/bin/bash

#scp -r dist/* dh_8wd5ar@67.205.14.4:/home/dh_8wd5ar/cybersyn.dev-pnuma.com/
echo "Subiendo Public Build:"
rsync -raP public/build/* u116825838@access1010342609.webspace-data.io:/kunden/homepages/12/d1010342609/htdocs/public/build/

echo "Subiendo los Resources/Views":
rsync -raP resources/* u116825838@access1010342609.webspace-data.io:/kunden/homepages/12/d1010342609/htdocs/resources/

echo "Subiendo los Controllers":
rsync -raP app/Http/Controllers/* u116825838@access1010342609.webspace-data.io:/kunden/homepages/12/d1010342609/htdocs/app/Http/Controllers/

echo "Subiendo las Rutas":
rsync -raP routes/* u116825838@access1010342609.webspace-data.io:/kunden/homepages/12/d1010342609/htdocs/routes/