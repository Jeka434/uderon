#Makefile for constructing Twig templates

#DO NOT CHANGE THESE
UDERON_DIR=uderon.com
SCRIPT_DIR=compilation_scripts
TEMPL_DIR=templates
TEST_DIR=tests

all:
	$(SCRIPT_DIR)/parseYAML.py >$(SCRIPT_DIR)/build_config.php
	php $(SCRIPT_DIR)/construct.php
	rm -rf compilation_cache

clean:
	rm -rf $(SCRIPT_DIR)/build_config.php

test:
	$(TEST_DIR)/init_test_dir.sh $(UDERON_DIR)

untest:
	$(TEST_DIR)/clean_test_dir.sh $(TEST_DIR)
