PROJECT_DIR=$(shell pwd)
GCI_TOP_DIR=$(PROJECT_DIR)/../project-ci
include $(GCI_TOP_DIR)/config/Makefile.d/var.d/*.mk
include $(GCI_TOP_DIR)/config/Makefile.d/register.d/app.mk
include $(GCI_TOP_DIR)/config/Makefile.d/register.d/ci.mk
include $(GCI_TOP_DIR)/config/Makefile.d/register.d/composer.mk
include $(GCI_TOP_DIR)/config/Makefile.d/register.d/git.mk
include $(GCI_TOP_DIR)/config/Makefile.d/register.d/php.mk
include $(GCI_TOP_DIR)/config/Makefile.d/task.d/*.mk
