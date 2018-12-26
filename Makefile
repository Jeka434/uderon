#Makefile for constructing Twig templates

#DO NOT CHANGE THESE
UDERON_DIR=uderon.com
SCRIPT_DIR=compilation_scripts
TEMPL_DIR=templates
TEST_DIR=tests
CSS_CHECK_FILE=$(SCRIPT_DIR)/css_check

#You can change this
CSS_FILE=$(UDERON_DIR)/html/styles/style.css
VCSS_DIFF=0.01

.PHONY: all clean test untest css_check

all: config.yml $(CSS_CHECK_FILE)
	$(SCRIPT_DIR)/parseYAML.py >$(SCRIPT_DIR)/build_config.php
	php $(SCRIPT_DIR)/construct.php
	rm -rf compilation_cache

clean:
	rm -rf $(SCRIPT_DIR)/build_config.php

test:
	$(TEST_DIR)/init_test_dir.sh $(UDERON_DIR)

untest:
	$(TEST_DIR)/clean_test_dir.sh $(TEST_DIR)

CSSVOLD=$(shell grep css_version config.yml | cut -d ":" -f2 | cut -d " " -f2)
CSSVNEW=$(shell echo "$(CSSVOLD) $(VCSS_DIFF) + p" | dc)

$(CSS_CHECK_FILE): $(CSS_FILE)
	sed "s/css_version: $(CSSVOLD)/css_version: $(CSSVNEW)/" config.yml >$(CSS_CHECK_FILE)
	cat $(CSS_CHECK_FILE) >config.yml
	echo $(CSSVNEW) >$(CSS_CHECK_FILE)
