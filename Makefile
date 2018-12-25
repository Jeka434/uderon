#Makefile for constructing Twig templates
UDERON_DIR=$PWD
SCRIPT_DIR=$(UDERON_DIR)/compilation_scripts
TEMPL_DIR=templates

all:
	$(SCRIPT_DIR)/parseYAML.py >$(SCRIPT_DIR)/build_config.php
	php $(SCRIPT_DIR)/construct.php
	#rm -rf $(SCRIPT_DIR)/compilation_cache
