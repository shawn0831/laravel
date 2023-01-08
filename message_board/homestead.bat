@echo off

set cwd=%cd%
set homesteadVagrant=C:\xampp\htdocs\xampp\laravel\message_board

cd /d %homesteadVagrant% && vagrant %*
cd /d %cwd%

set cwd=
set homesteadVagrant=