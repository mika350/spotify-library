VENDOR_DIR="vendor/"

if [ -d "$VENDOR_DIR" ]; then
  printf "Vendor directory found. Start testing."

  printf "\n####################################################################\n"

  printf "Start PHP CodeSniffer\n"
  vendor/bin/phpcs
  printf "Finished PHP CodeSniffer"

  printf "\n####################################################################\n"

  printf "Start PHPStan\n"
  vendor/bin/phpstan analyse src/
  printf "Finished PHPStan"

  printf "\n####################################################################\n"

  printf "Start Deptrac\n"
  vendor/bin/deptrac
  printf "Finished Deptrac"^

  exit 0
else
  printf "Error: ${DIR} not found. Can not continue."
  exit 1
fi