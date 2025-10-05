#!/bin/bash

# Script to enable/disable Xdebug dynamically
# Usage: ./bin/scripts/xdebug.sh [on|off]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored messages
print_error() {
    echo -e "${RED}ERROR: $1${NC}" >&2
}

print_success() {
    echo -e "${GREEN}SUCCESS: $1${NC}"
}

print_info() {
    echo -e "${YELLOW}INFO: $1${NC}"
}

# Check if parameter is provided
if [ -z "$1" ]; then
    print_error "Missing parameter. Usage: $0 [on|off]"
    exit 1
fi

ACTION="$1"

# Validate parameter
if [ "$ACTION" != "on" ] && [ "$ACTION" != "off" ]; then
    print_error "Invalid parameter '$ACTION'. Use 'on' or 'off'"
    exit 1
fi

# Get PHP configuration directory dynamically
print_info "Detecting PHP configuration..."
PHP_INI_DIR=$(php --ini | grep "Scan for additional .ini files" | cut -d: -f2 | xargs)

if [ -z "$PHP_INI_DIR" ]; then
    print_error "Could not detect PHP configuration directory"
    exit 1
fi

print_info "PHP configuration directory: $PHP_INI_DIR"

# Look for Xdebug configuration file
XDEBUG_INI=""
for ini_file in "$PHP_INI_DIR"/*.ini; do
    if [ -f "$ini_file" ] && grep -q "xdebug" "$ini_file" 2>/dev/null; then
        XDEBUG_INI="$ini_file"
        break
    fi
done

if [ -z "$XDEBUG_INI" ]; then
    print_error "Could not find Xdebug configuration file in $PHP_INI_DIR"
    exit 1
fi

print_info "Xdebug configuration file: $XDEBUG_INI"

# Check if we have write permissions
if [ ! -w "$XDEBUG_INI" ]; then
    print_error "No write permission for $XDEBUG_INI"
    print_info "Try running with sudo: sudo $0 $ACTION"
    exit 1
fi

# Backup the original file
BACKUP_FILE="${XDEBUG_INI}.backup"
if [ ! -f "$BACKUP_FILE" ]; then
    cp "$XDEBUG_INI" "$BACKUP_FILE"
    print_info "Created backup: $BACKUP_FILE"
fi

# Enable or disable Xdebug
if [ "$ACTION" == "off" ]; then
    print_info "Disabling Xdebug..."
    
    # Comment out zend_extension line
    sed -i.tmp 's/^zend_extension/;zend_extension/g' "$XDEBUG_INI"
    
    # Comment out all xdebug.* lines that aren't already commented
    sed -i.tmp 's/^xdebug\./;xdebug\./g' "$XDEBUG_INI"
    
    # Remove temporary file
    rm -f "${XDEBUG_INI}.tmp"
    
    print_success "Xdebug has been disabled"
    
elif [ "$ACTION" == "on" ]; then
    print_info "Enabling Xdebug..."
    
    # Uncomment zend_extension line
    sed -i.tmp 's/^;*zend_extension/zend_extension/g' "$XDEBUG_INI"
    
    # Uncomment all xdebug.* lines
    sed -i.tmp 's/^;*xdebug\./xdebug\./g' "$XDEBUG_INI"
    
    # Remove temporary file
    rm -f "${XDEBUG_INI}.tmp"
    
    print_success "Xdebug has been enabled"
fi

# Show current status
echo ""
print_info "Current Xdebug status:"
if php -v | grep -q "Xdebug"; then
    print_success "Xdebug is ACTIVE"
    php -v | grep "Xdebug"
else
    print_info "Xdebug is INACTIVE"
fi

echo ""
print_info "Note: If you're using PHP-FPM, you may need to restart it:"
echo "  brew services restart php"
echo "  or"
echo "  sudo brew services restart php@8.4"