#!/bin/bash

(
	cd web;
	php -S localhost:8000 ../router.php;
)
