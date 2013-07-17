<?php
$I = new WebGuy($scenario);
$I->wantTo('check if Jakob lives');
$I->amOnPage('/person/jakob'); 
$I->see('Jakob');
$I->see('"alive":true');
