  #!/bin/bash

rm -r ../data/*

php download_backup_lattes.php

NOW=$(date +"%m-%d-%Y")
FILE="backup.$NOW.zip"

zip -r ../backup/$FILE ../data