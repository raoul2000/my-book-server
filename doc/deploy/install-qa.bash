#!/bin/bash

set -e #stop on error

SCRIPT=$(realpath $0)
SCRIPTPATH=$(dirname $SCRIPT)

# script parameter is package filename
# example: script.bash source-qa-1.2020.2.zip

SRC_FILENAME="$1"
SRC_FILE="$SCRIPTPATH/$SRC_FILENAME"

if [ ! -f "$SRC_FILE" ];
then
    echo "file not found : $SRC_FILE"
    exit 1
fi
INSTALL_FOLDER=$(date '+%Y-%m-%d_%H-%M-%S')
INSTALL_PATH="$SCRIPTPATH/../$INSTALL_FOLDER"
mkdir -p "$INSTALL_PATH"
cp "$SRC_FILE" "$INSTALL_PATH"

unzip -d "$INSTALL_PATH" "$SRC_FILENAME"
rm "$INSTALL_PATH/$SRC_FILENAME"*

# update the symlink
cd ..
ln -sfn "$INSTALL_FOLDER" dev

echo ""
echo "done"
echo ""

exit 0
