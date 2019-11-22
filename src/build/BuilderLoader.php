<?php

namespace Builder;

require_once __DIR__ . '/../../vendor/classpreloader/classpreloader/src/ClassLoader.php';

use ClassPreloader\ClassLoader;

class BuilderLoader extends ClassLoader
{
    /**
     * Get an array of loaded file names in order of loading.
     *
     * @return array
     */
    public function getFilenames()
    {
        $files = [];
        foreach ($this->classList->getClasses() as $class)
        {
            // Push interfaces before classes if not already loaded
            try
            {
                $r = new \ReflectionClass($class);
                foreach ($r->getInterfaces() as $inf)
                {
                    $name = $inf->getFileName();
                    if ($name && !in_array($name, $files))
                    {
                        $files[] = $name;
                    }
                }
                if (!in_array($r->getFileName(), $files))
                {
                    $files[] = $r->getFileName();
                }
            }
            catch (\ReflectionException $e)
            {
                // We ignore all exceptions related to reflection because in
                // some cases class doesn't need to exist. We're ignoring all
                // problems with classes, interfaces and traits.
            }
        }
        return $files;
    }
}