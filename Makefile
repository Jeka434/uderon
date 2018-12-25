#Makefile for constructing Twig templates

SCRIPT_DIR=compilation_scripts
TEMPL_DIR=templates

all:
	$(SCRIPT_DIR)/parseYAML.py >$(SCRIPT_DIR)/build_config.php
	php $(SCRIPT_DIR)/construct.php
	rm -rf $(UDERON_DIR)/compilation_cache

clean:
	rm -rf $(SCRIPT_DIR)/build_config.php
