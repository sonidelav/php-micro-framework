<?php
require_once __DIR__ . '/../../../vendor/classpreloader/classpreloader/src/ClassLoader.php';

use ClassPreloader\ClassLoader;

$config = ClassLoader::getIncludes(function(ClassLoader $loader) {
    require_once __DIR__ . '/../../../vendor/autoload.php';
    $loader->register();
    require_once __DIR__ . '/../../../src/app/bootstrap.php';
});

// Add a regex filter that requires all classes to match the regex.
// $config->addInclusiveFilter('/Foo/');

// Add a regex filter that requires that a class does not match the filter.
// $config->addExclusiveFilter('/Foo/');

return $config;
