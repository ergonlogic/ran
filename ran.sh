#!/bin/bash

function ran_result() {
  TASK=$1
  STATUS=$2
  COLOUR=$3
  TEXT_WIDTH=$((${#TASK}+${#STATUS}+6))
  TERM_WIDTH=`tput cols`
  printf "$TASK"
  SPACER=$(($TERM_WIDTH-$TEXT_WIDTH))
  i=1
  while [ "$i" -le "$SPACER" ]; do
    printf "."
    i=$(($i + 1))
  done
  RESET="\033[0m"
  printf " [ $COLOUR$STATUS$RESET ]\n"
}

function ran_success() {
  TASK=$1
  STATUS='ok'
  COLOUR="\033[1;32m"
  ran_result "$TASK" "$STATUS" "$COLOUR"
}

function ran_failure() {
  TASK=$1
  STATUS='failed'
  COLOUR="\033[1;31m"
  ran_result "$TASK" "$STATUS" "$COLOUR"
}

function ran_chkdeps() {
  DESC='Dependency check'
  for dep in "$1[@]" ; do
    KEY="${dep%%:*}"
    VALUE="${dep#*:}"
    which $KEY >/dev/null 2>&1
    if [ $? = 0 ]; then
      ran_success "$DESC"
    else
      ran_failure "$DESC"
      printf "Rán depends on the '%s' command, but it doesn't appear to be installed.\n" "$KEY"
      printf "Please follow the instructions at %s to install it.\n" "$VALUE"
      exit 1
    fi
  done
}

# Array pretending to be a Pythonic dictionary
DEPENDENCIES=(
  "vagrant:http://www.vagrantup.com/downloads.html"
)

ran_chkdeps $DEPENDENCIES
exit 0
